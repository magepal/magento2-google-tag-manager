<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\ProductData;

use Magento\Catalog\Model\Product;

abstract class ProductImpressionAbstract
{
    /**
     * @var ProductImpressionProvider[]
     */
    protected $productImpressionProviders;

    /**
     * @var array
     */
    private $item = [];

    /**
     */
    private $product;

    /** @var string */
    private $listType = '';

    /**
     * @return array
     */
    abstract public function getData();

    /**
     * @return array
     */
    public function getItemData()
    {
        return (array) $this->item;
    }

    /**
     * @param array $item
     * @return ProductImpressionAbstract
     */
    public function setItemData(array $item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return ProductImpressionAbstract
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return array|ProductImpressionAbstract[]
     */
    public function getProductImpressionProviders()
    {
        return $this->productImpressionProviders;
    }

    /**
     * @return string
     */
    public function getListType()
    {
        return $this->listType;
    }

    /**
     * @param string $listType
     * @return ProductImpressionAbstract
     */
    public function setListType(string $listType)
    {
        $this->listType = $listType;
        return $this;
    }
}
