<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\OrderData;

class OrderProvider extends OrderAbstract
{
    /**
     * @param array $orderProviders
     */
    public function __construct(
        array $orderProviders = []
    ) {
        $this->orderProviders = $orderProviders;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data =  $this->getTransactionData();
        $arraysToMerge = [];

        foreach ($this->getOrderProviders() as $orderProvider) {
            $orderProvider->setOrder($this->getOrder())->setTransactionData($data);
            $arraysToMerge[] = $orderProvider->getData();
        }

        return empty($arraysToMerge) ? $data : array_merge($data, ...$arraysToMerge);
    }
}
