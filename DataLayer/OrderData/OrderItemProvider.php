<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\OrderData;

class OrderItemProvider extends OrderItemAbstract
{
    /**
     * @param array $orderItemProviders
     */
    public function __construct(
        array $orderItemProviders = []
    ) {
        $this->orderItemProviders = $orderItemProviders;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data =  $this->getItemData();
        $arraysToMerge = [];

        foreach ($this->getOrderItemProviders() as $orderItemProvider) {
            $orderItemProvider->setItem($this->getItem())->setItemData($data);
            $arraysToMerge[] = $orderItemProvider->getData();
        }

        return empty($arraysToMerge) ? $data : array_merge($data, ...$arraysToMerge);
    }
}
