<?php
/**
 * Google Tag Manager
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Model;

use Magento\Framework\DataObject;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface;
use MagePal\GoogleTagManager\Helper\Data as GtmHelper;

/**
 * Class Order
 * @package MagePal\GoogleTagManager\Model
 * @method Array setOrderIds(Array $orderIds)
 * @method Array getOrderIds()
 */
class Order extends DataObject
{

    /**
     * @var gtmHelper
     */
    protected $gtmHelper;

    /**
     * @var CollectionFactory
     */
    protected $_salesOrderCollection;

    protected $_orderCollection = null;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $_storeManager;

    /**
     * Escaper
     *
     * @var \Magento\Framework\Escaper
     */
    protected $_escaper;

    /**
     * Order constructor.
     * @param CollectionFactoryInterface $salesOrderCollection
     * @param GtmHelper $gtmHelper
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Escaper $escaper
     * @param array $data
     */
    public function __construct(
        CollectionFactoryInterface $salesOrderCollection,
        GtmHelper $gtmHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Escaper $escaper,
        array $data = []
    ) {
        parent::__construct($data);
        $this->gtmHelper = $gtmHelper;
        $this->_salesOrderCollection = $salesOrderCollection;
        $this->_storeManager = $storeManager;
        $this->_escaper = $escaper;
    }

    /**
     * Render information about specified orders and their items
     *
     * @return void|string
     */
    public function getOrderLayer()
    {
        $collection = $this->getOrderCollection();

        if (!$collection) {
            return false;
        }

        $result = [];

        /* @var \Magento\Sales\Model\Order $order */

        foreach ($collection as $order) {
            $products = [];
            foreach ($order->getAllVisibleItems() as $item) {
                $products[] = [
                    'sku' => $item->getSku(),
                    'name' => $this->escapeJsQuote($item->getName()),
                    'price' => $this->gtmHelper->formatPrice($item->getBasePrice()),
                    'quantity' => $item->getQtyOrdered() * 1
                ];
            }

            $transaction =[
                'event' => 'gtm.orderComplete',
                'transactionId' => $order->getIncrementId(),
                'transactionAffiliation' => $this->escapeJsQuote($this->_storeManager->getStore()->getFrontendName()),
                'transactionTotal' => $this->gtmHelper->formatPrice($order->getBaseGrandTotal()),
                'transactionSubTotal' => $this->gtmHelper->formatPrice($order->getBaseSubtotal()),
                'transactionShipping' => $this->gtmHelper->formatPrice($order->getBaseShippingAmount()),
                'transactionTax' => $this->gtmHelper->formatPrice($order->getTaxAmount()),
                'transactionCouponCode' => $order->getCouponCode(),
                'transactionDiscount' => $this->gtmHelper->formatPrice($order->getDiscountAmount()),
                'transactionProducts' => $products
            ];

            $result[] = $transaction;
        }

        return $result;
    }

    /**
     * Get order collection
     *
     * @return bool|\Magento\Sales\Model\ResourceModel\Order\Collection|null
     */
    public function getOrderCollection()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return false;
        }

        if (!$this->_orderCollection) {
            $this->_orderCollection = $this->_salesOrderCollection->create();
            $this->_orderCollection->addFieldToFilter('entity_id', ['in' => $orderIds]);
        }

        return $this->_orderCollection;
    }

    /**
     * Escape quotes in java scripts
     *
     * @param string|array $data
     * @param string $quote
     * @return string|array
     */
    public function escapeJsQuote($data, $quote = '\'')
    {
        return $this->_escaper->escapeJsQuote($data, $quote);
    }
}
