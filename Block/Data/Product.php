<?php
/**
 * Google Tag Manager
 *
 * Copyright © 2017 MagePal. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagePal\GoogleTagManager\Block\Data;

use Magento\Catalog\Block\Product\Context;
use \Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Helper\Data;

/**
 * Block : Product for catalog product view page
 *
 * @package MagePal\GoogleTagManager
 * @class   Product
 */
class Product extends \Magento\Catalog\Block\Product\AbstractProduct
{
    /**
     * Catalog data
     *
     * @var Data
     */
    protected $_catalogData = null;

    /**
     * @param Context|Context $context
     * @param Data $catalogData
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $catalogData,
        array $data = []
    ) {
        $this->_catalogData = $catalogData;
        parent::__construct($context, $data);
    }


    /**
     * Add product data to datalayer
     *
     * @return $this
     */
    function _prepareLayout()
    {
        /** @var $tm \MagePal\GoogleTagManager\Block\DataLayer */
        $tm = $this->getParentBlock();

        /** @var $product \Magento\Catalog\Api\Data\ProductInterface */ 
        $product = $this->getProduct();

        $tm->addVariable(
            'list', 
            'detail'
        );


        $titleArray = [];
        $breadCrumbs = $this->_catalogData->getBreadcrumbPath();

        foreach($breadCrumbs as $breadCrumb){
            $titleArray[] = $breadCrumb['label'];
        }

        $tm->addVariable(
            'product', 
            [
                'id' => $product->getId(),
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'price' => $product->getTypeId() == Type::TYPE_SIMPLE ? $tm->formatPrice($product->getPrice()) : $tm->formatPrice($product->getFinalPrice()),
                'attribute_set_id' => $product->getAttributeSetId(),
                'path' => implode(" > ", $titleArray)
            ]
        );
    }
}
