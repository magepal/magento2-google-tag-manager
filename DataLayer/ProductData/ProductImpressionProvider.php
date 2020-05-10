<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\ProductData;

class ProductImpressionProvider extends ProductImpressionAbstract
{

    /**
     * @param array $productImpressionProviders
     * @codeCoverageIgnore
     */
    public function __construct(
        array $productImpressionProviders = []
    ) {
        $this->productImpressionProviders = $productImpressionProviders;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data =  $this->getItemData();
        $arraysToMerge = [];

        /** @var ProductImpressionAbstract $productImpressionProvider */
        foreach ($this->getProductImpressionProviders() as $productImpressionProvider) {
            $productImpressionProvider->setProduct($this->getProduct())->setItemData($data);
            $arraysToMerge[] = $productImpressionProvider->getData();
        }

        return empty($arraysToMerge) ? $data : array_merge($data, ...$arraysToMerge);
    }
}
