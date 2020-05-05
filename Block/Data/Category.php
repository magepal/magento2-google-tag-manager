<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block\Data;

use Magento\Catalog\Model\Category as ProductCategory;
use Magento\Catalog\Helper\Data;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagePal\GoogleTagManager\Block\DataLayer;
use MagePal\GoogleTagManager\DataLayer\CategoryData\CategoryProvider;
use MagePal\GoogleTagManager\Model\DataLayerEvent;

class Category extends Template
{
    /**
     * Catalog data
     *
     * @var Data
     */
    protected $_catalogData = null;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry = null;
    /**
     * @var CategoryProvider
     */
    private $categoryProvider;

    /**
     * @param  Context  $context
     * @param  Registry  $registry
     * @param  Data  $catalogData
     * @param  CategoryProvider  $categoryProvider
     * @param  array  $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Data $catalogData,
        CategoryProvider $categoryProvider,
        array $data = []
    ) {
        $this->_catalogData = $catalogData;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
        $this->categoryProvider = $categoryProvider;
    }

    /**
     * Retrieve current category model object
     *
     * @return \Magento\Catalog\Model\Category
     */
    public function getCurrentCategory()
    {
        if (!$this->hasData('current_category')) {
            $this->setData('current_category', $this->_coreRegistry->registry('current_category'));
        }
        return $this->getData('current_category');
    }

    /**
     * Add category data to datalayer
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        /** @var $tm DataLayer */
        $tm = $this->getParentBlock();

        /** @var $category ProductCategory */
        $category = $this->getCurrentCategory();

        if ($category) {
            $categoryData = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'path' => $this->getCategoryPath()
            ];

            $categoryData = $this->categoryProvider
                ->setCategory($category)
                ->setCategoryData($categoryData)
                ->getData();

            $data = [
                'event' => DataLayerEvent::CATEGORY_PAGE_EVENT,
                'category' => $categoryData
            ];

            $tm->addVariable('list', 'category');
            $tm->addCustomDataLayerByEvent(DataLayerEvent::CATEGORY_PAGE_EVENT, $data);
        }

        return $this;
    }

    public function getCategoryPath()
    {
        $titleArray = [];
        $breadCrumbs = $this->_catalogData->getBreadcrumbPath();

        foreach ($breadCrumbs as $breadCrumb) {
            $titleArray[] = $breadCrumb['label'];
        }

        return implode(" > ", $titleArray);
    }
}
