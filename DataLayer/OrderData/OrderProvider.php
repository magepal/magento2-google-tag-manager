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
     * @return array
     */
    public function getData()
    {
        $data =  $this->getTransactionData();
        /** @var OrderAbstract $orderProvider */
        foreach ($this->getOrderProviders() as $orderProvider) {
            $orderProvider->setOrder($this->getOrder())->setTransactionData($data);

            $data = array_merge_recursive($data, $orderProvider->getData());
        }

        return $data;
    }
}
