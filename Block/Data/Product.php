<?php
/**
 * Blocks feeding datalayer
 *
 * @category  MagePal
 * @package   MagePal\GoogleTagManager
 * @author    Pascal Noisette <netpascal0123@aol.com>
 * @copyright 2017
 */
namespace MagePal\GoogleTagManager\Block\Data;


/**
 * Block : Product for catalog product view page
 *
 * @package MagePal\GoogleTagManager
 * @class   Product
 */
class Product extends \Magento\Catalog\Block\Product\AbstractProduct
{
    /**
     * Add product data to datalayer
     *
     * @return $this
     */
    function _prepareLayout()
    {
        /** @var $tm \MagePal\GoogleTagManager\Block\Tm */
        $tm = $this->getParentBlock();

        /** @var $product \Magento\Catalog\Api\Data\ProductInterface */ 
        $product = $this->getProduct();

        $tm->addVariable(
            'list', 
            'detail'
        );

        $tm->addVariable(
            'product', 
            [
                'id' => $product->getId(),
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'attribute_set_id' => $product->getAttributeSetId()
            ]
        );
    }
}
