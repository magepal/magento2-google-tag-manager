<?php

/**
 * DataLayer
 * Copyright © 2016 MagePal. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagePal\GoogleTagManager\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cookie\Helper\Cookie as CookieHelper;
use MagePal\GoogleTagManager\Helper\Data as GtmHelper;


/**
 * Google Tag Manager Block
 */
class Tm extends Template {

    /**
     * Google Tag Manager Helper
     *
     * @var \Google\TagManager\Helper\Data
     */
    protected $_gtmHelper = null;

    /**
     * Cookie Helper
     *
     * @var \Magento\Cookie\Helper\Cookie
     */
    protected $_cookieHelper = null;

    /**
     * Cookie Helper
     *
     * @var \MagePal\TagManager\Model\DataLayer
     */
    protected $_dataLayerModel = null;
    
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $_salesOrderCollection;


    /**
     * @param Context $context
     * @param CookieHelper $cookieHelper
     * @param GtmHelper $gtmHelper
     * @param \MagePal\GoogleTagManager\Model\DataLayer $dataLayer
     * @param array $data
     */
    public function __construct(
        Context $context, 
        GtmHelper $gtmHelper, 
        CookieHelper $cookieHelper, 
        \MagePal\GoogleTagManager\Model\DataLayer $dataLayer,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderCollection,
        array $data = []
    ) {
        $this->_cookieHelper = $cookieHelper;
        $this->_gtmHelper = $gtmHelper;
        $this->_dataLayerModel = $dataLayer;
        $this->_salesOrderCollection = $salesOrderCollection;
        parent::__construct($context, $data);

        $this->addVariable('ecommerce', ['currencyCode' => $this->_storeManager->getStore()->getCurrentCurrency()->getCode()]);
    }
    
    /**
     * Render information about specified orders and their items
     * 
     * @return void|string
     */
    protected function getOrdersTrackingCode()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }

        $collection = $this->_salesOrderCollection->create();
        $collection->addFieldToFilter('entity_id', ['in' => $orderIds]);
        $result = [];
        
        foreach ($collection as $order) {
                        
            foreach ($order->getAllVisibleItems() as $item) {
                $product[] = array(
                    'sku' => $item->getSku(),
                    'name' => $item->getName(),
                    'price' => $item->getBasePrice(),
                    'quantity' => $item->getQtyOrdered()
                );
            }
            
            $transaction = array(
                'transactionId' => $order->getIncrementId(),
                'transactionAffiliation' => $this->escapeJsQuote($this->_storeManager->getStore()->getFrontendName()),
                'transactionTotal' => $order->getBaseGrandTotal(),
                'transactionShipping' => $order->getBaseShippingAmount(),
                'transactionProducts' => $product
            );
            
            
            $result[] = sprintf("dataLayer.push(%s);", json_encode($transaction));
        }
        
        return implode("\n", $result) . "\n";
    }

    /**
     * Render tag manager script
     *
     * @return string
     */
    protected function _toHtml() {
        if ($this->_cookieHelper->isUserNotAllowSaveCookie() || !$this->_gtmHelper->isEnabled()) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * Return data layer json
     *
     * @return json
     */
    public function getGtmTrackingCode() {
        return sprintf("dataLayer.push(%s);\n", json_encode($this->_dataLayerModel->getVariables()));
    }

    public function addVariable($name, $value) {
        $this->_dataLayerModel->addVariable($name, $value);
        
        return $this;
    }

}
