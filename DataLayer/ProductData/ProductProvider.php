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
     * @return array
     */
    public function getData()
    {
        $data =  $this->getTransactionData();
        /** @var ProductAbstract $productProvider */
        foreach ($this->getProductProviders() as $productProvider) {
            $productProvider->setProduct($this->getProduct())->setTransactionData($data);

            $data = array_merge_recursive($data, $productProvider->getData());
        }

        return $data;
    }
}
