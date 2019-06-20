<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\ProductData;

use Magento\Sales\Model\Product;

/**
 * Class ProductAbstract
 * @package MagePal\GoogleTagManager\DataLayer\ProductData
 */
abstract class ProductAbstract
{
    /**
     * @var ProductProvider[]
     */
    private $productProviders;

    /**
     * @var array
     */
    private $transactionData = [];

    /**
     */
    private $product;

    /**
     * @param array $productProviders
     * @codeCoverageIgnore
     */
    public function __construct(
        array $productProviders = []
    ) {
        $this->productProviders = $productProviders;
    }

    /**
     * @return array
     */
    abstract public function getData();

    /**
     * @return array
     */
    public function getTransactionData()
    {
        return (array) $this->transactionData;
    }

    /**
     * @param array $transactionData
     * @return ProductAbstract
     */
    public function setTransactionData(array $transactionData)
    {
        $this->transactionData = $transactionData;
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
