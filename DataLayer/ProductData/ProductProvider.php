<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\ProductData;

/**
 * Class ProductProvider
 * @package MagePal\GoogleTagManager\DataLayer\ProductData
 */
class ProductProvider extends ProductAbstract
{
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
    public function getData()
    {
        $data =  $this->getProductData();
        /** @var ProductAbstract $productProvider */
        foreach ($this->getProductProviders() as $productProvider) {
            $productProvider->setProduct($this->getProduct())->setProductData($data);

            $data = array_merge($data, $productProvider->getData());
        }

        return $data;
    }
}
