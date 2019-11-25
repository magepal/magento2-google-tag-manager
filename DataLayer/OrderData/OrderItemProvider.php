<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\OrderData;

/**
 * Class OrderItemProvider
 * @package MagePal\GoogleTagManager\DataLayer\OrderData
 */
class OrderItemProvider extends OrderItemAbstract
{
    /**
     * @param array $orderItemProviders
     * @codeCoverageIgnore
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
        /** @var OrderItemAbstract $orderItemProvider */
        foreach ($this->getOrderItemProviders() as $orderItemProvider) {
            $orderItemProvider->setItem($this->getItem())->setItemData($data);

            $data = array_merge($data, $orderItemProvider->getData());
        }

        return $data;
    }
}
