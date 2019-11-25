<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\OrderData;

/**
 * Class OrderProvider
 * @package MagePal\GoogleTagManager\DataLayer\OrderData
 */
class OrderProvider extends OrderAbstract
{
    /**
     * @param array $orderProviders
     * @codeCoverageIgnore
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
        /** @var OrderAbstract $orderProvider */
        foreach ($this->getOrderProviders() as $orderProvider) {
            $orderProvider->setOrder($this->getOrder())->setTransactionData($data);

            $data = array_merge($data, $orderProvider->getData());
        }

        return $data;
    }
}
