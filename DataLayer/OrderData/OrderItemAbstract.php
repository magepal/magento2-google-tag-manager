<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\OrderData;

use Magento\Sales\Model\Order\Item;

/**
 * Class OrderItemAbstract
 * @package MagePal\GoogleTagManager\DataLayer\OrderData
 */
abstract class OrderItemAbstract
{
    const LIST_TYPE_GOOGLE = 1;

    const LIST_TYPE_GENERIC = 2;

    protected $listType;

    /**
     * @var OrderItemProvider[]
     */
    private $orderItemProviders;

    /**
     * @var array
     */
    private $itemData = [];

    /**
     * @var Item
     */
    private $item;

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
    abstract public function getData();

    /**
     * @return array
     */
    public function getItemData()
    {
        return (array) $this->itemData;
    }

    /**
     * @param array $itemData
     * @return OrderItemAbstract
     */
    public function setItemData(array $itemData)
    {
        $this->itemData = $itemData;
        return $this;
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Item $item
     * @return OrderItemAbstract
     */
    public function setItem(Item $item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return OrderItemProvider[]
     */
    public function getOrderItemProviders()
    {
        return $this->orderItemProviders;
    }

    /**
     * @return mixed
     */
    public function getListType()
    {
        return $this->listType;
    }

    /**
     * @param mixed $listType
     * @return OrderItemAbstract
     */
    public function setListType($listType)
    {
        $this->listType = $listType;
        return $this;
    }
}
