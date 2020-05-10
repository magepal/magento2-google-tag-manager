<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\OrderData;

use Magento\Sales\Model\Order;

abstract class OrderAbstract
{
    /**
     * @var OrderProvider[]
     */
    protected $orderProviders;

    /**
     * @var array
     */
    private $transactionData = [];

    /**
     * @var Order
     */
    private $order;

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
     * @return OrderAbstract
     */
    public function setTransactionData(array $transactionData)
    {
        $this->transactionData = $transactionData;
        return $this;
    }

    /**
     * @param Order $order
     * @return OrderAbstract
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return OrderProvider[]
     */
    public function getOrderProviders()
    {
        return $this->orderProviders;
    }
}
