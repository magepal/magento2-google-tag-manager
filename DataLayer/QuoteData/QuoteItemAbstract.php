<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\QuoteData;

use Magento\Quote\Model\Quote\Item;

abstract class QuoteItemAbstract
{
    const LIST_TYPE_GOOGLE = 1;
    const LIST_TYPE_GENERIC = 2;
    const ACTION_ADDED_ITEM = 1;
    const ACTION_REMOVED_ITEM = 2;
    const ACTION_UPDATED_ITEM = 3;
    const ACTION_VIEW_CART = 4;

    /**
     * @var QuoteItemProvider[]
     */
    protected $quoteItemProviders;

    /**
     * @var
     */
    protected $actionType;

    /**
     * @var
     */
    protected $listType;

    /**
     * @var array
     */
    private $itemData = [];

    /**
     * @var Item
     */
    private $item;

    /**
     * @return array
     */
    public function getItemData()
    {
        return (array) $this->itemData;
    }

    /**
     * @param array $itemData
     * @return QuoteItemAbstract
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
     * @return QuoteItemAbstract
     */
    public function setItem(Item $item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return array|QuoteItemAbstract[]
     */
    public function getQuoteItemProviders()
    {
        return $this->quoteItemProviders;
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
     * @return QuoteItemAbstract
     */
    public function setListType($listType)
    {
        $this->listType = $listType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionType()
    {
        return $this->actionType;
    }

    /**
     * @param mixed $actionType
     * @return QuoteItemAbstract
     */
    public function setActionType($actionType)
    {
        $this->actionType = $actionType;
        return $this;
    }
}
