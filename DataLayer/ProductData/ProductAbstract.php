<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\ProductData;

use Magento\Catalog\Model\Product;

abstract class ProductAbstract
{
    /**
     * @var ProductProvider[]
     */
    protected $productProviders;

    /**
     * @var array
     */
    private $productData = [];

    /**
     */
    private $product;

    /**
     * @return array
     */
    abstract public function getData();

    /**
     * @return array
     */
    public function getProductData()
    {
        return (array) $this->productData;
    }

    /**
     * @param array $productData
     * @return ProductAbstract
     */
    public function setProductData(array $productData)
    {
        $this->productData = $productData;
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
     * @return ProductAbstract
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return array|ProductAbstract[]
     */
    public function getProductProviders()
    {
        return $this->productProviders;
    }
}
