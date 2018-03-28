<?php
/**
 * Google Tag Manager
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block\Data;

use Magento\Catalog\Helper\Data;

/**
 * Block : Category for catalog category view page
 *
 * @package MagePal\GoogleTagManager
 * @class   Category
 */
class Category extends \Magento\Framework\View\Element\Template
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
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        Data $catalogData,
        array $data = []
    ) {
        $this->_catalogData = $catalogData;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
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
        /** @var $tm \MagePal\GoogleTagManager\Block\DataLayer */
        $tm = $this->getParentBlock();

        /** @var $product \Magento\Catalog\Api\Data\ProductInterface */
        $category = $this->getCurrentCategory();

        if (!$category) {
            return;
        }

        $tm->addVariable(
            'list',
            'category'
        );

        $titleArray = [];
        $breadCrumbs = $this->_catalogData->getBreadcrumbPath();

        foreach ($breadCrumbs as $breadCrumb) {
            $titleArray[] = $breadCrumb['label'];
        }

        $tm->addVariable(
            'category',
            [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'path' => implode(" > ", $titleArray)
            ]
        );

        return $this;
    }
}
