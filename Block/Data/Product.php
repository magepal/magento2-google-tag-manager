<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block\Data;

use Exception;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Helper\Data;
use Magento\Catalog\Model\Product\Type;
use MagePal\GoogleTagManager\Block\DataLayer;
use MagePal\GoogleTagManager\DataLayer\ProductData\ProductProvider;
use MagePal\GoogleTagManager\Helper\Product as ProductHelper;
use MagePal\GoogleTagManager\Model\DataLayerEvent;

class Product extends AbstractProduct
{
    /**
     * Catalog data
     *
     * @var Data
     */
    protected $catalogHelper = null;
    /**
     * @var ProductHelper
     */
    private $productHelper;
    /**
     * @var ProductProvider
     */
    private $productProvider;

    /**
     * @param  Context  $context
     * @param  ProductHelper  $productHelper
     * @param  ProductProvider  $productProvider
     * @param  array  $data
     */
    public function __construct(
        Context $context,
        ProductHelper $productHelper,
        ProductProvider $productProvider,
        array $data = []
    ) {
        $this->catalogHelper = $context->getCatalogHelper();
        parent::__construct($context, $data);
        $this->productHelper = $productHelper;
        $this->productProvider = $productProvider;
    }

    /**
     * Add product data to datalayer
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        /** @var $tm DataLayer */
        $tm = $this->getParentBlock();

        if ($product = $this->getProduct()) {
            $productData = [
                'id' => $product->getId(),
                'sku' => $product->getSku(),
                'parent_sku' => $product->getData('sku'),
                'product_type' => $product->getTypeId(),
                'name' => $product->getName(),
                'price' => $this->getPrice(),
                'attribute_set_id' => $product->getAttributeSetId(),
                'path' => implode(" > ", $this->getBreadCrumbPath()),
                'category' => $this->getProductCategoryName(),
                'image_url' => $this->productHelper->getImageUrl($product)
            ];

            $productData = $this->productProvider->setProduct($product)->setProductData($productData)->getData();

            $data = [
                'event' => DataLayerEvent::PRODUCT_PAGE_EVENT,
                'product' => $productData
            ];

            $tm->addVariable('list', 'detail');
            $tm->addCustomDataLayerByEvent(DataLayerEvent::PRODUCT_PAGE_EVENT, $data);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        /** @var $tm DataLayer */
        $tm = $this->getParentBlock();
        $price = 0;

        /** @var $product ProductInterface */
        if ($product = $this->getProduct()) {
            if ($product->getTypeId() == Type::TYPE_SIMPLE) {
                $price = $product->getPrice();
            } else {
                $price = $product->getFinalPrice();
            }
        }

        return $tm->formatPrice($price);
    }

    /**
     * Get category name from breadcrumb
     *
     * @return string
     */
    protected function getProductCategoryName()
    {
        $categoryName = '';

        try {
            $categoryArray = $this->getBreadCrumbPath();

            if (count($categoryArray) > 1) {
                end($categoryArray);
                $categoryName = prev($categoryArray);
            } elseif ($this->getProduct()) {
                $category = $this->getProduct()->getCategoryCollection()->addAttributeToSelect('name')->getFirstItem();
                $categoryName = ($category) ? $category->getName() : '';
            }
        } catch (Exception $e) {
            $categoryName = '';
        }

        return $categoryName;
    }

    /**
     * Get bread crumb path
     *
     * @return array
     */
    protected function getBreadCrumbPath()
    {
        $titleArray = [];
        $breadCrumbs = $this->catalogHelper->getBreadcrumbPath();

        foreach ($breadCrumbs as $breadCrumb) {
            $titleArray[] = $breadCrumb['label'];
        }

        return $titleArray;
    }
}
