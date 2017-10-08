<?php
/**
 * Google Tag Manager
 *
 * Copyright © 2017 MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagePal\GoogleTagManager\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

    const XML_PATH_ACTIVE = 'googletagmanager/general/active';
    const XML_PATH_ACCOUNT = 'googletagmanager/general/account';


    protected $_dataLayerName = 'dataLayer';

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\ObjectManagerInterface
     */
    public function __construct(
    \Magento\Framework\App\Helper\Context $context, \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        $this->_objectManager = $objectManager;
        parent::__construct($context);
    }

    /**
     * Whether Tag Manager is ready to use
     *
     * @return bool
     */
    public function isEnabled() {
        $accountId = $this->scopeConfig->getValue(self::XML_PATH_ACCOUNT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $accountId && $this->scopeConfig->isSetFlag(self::XML_PATH_ACTIVE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Tag Manager Account ID
     *
     * @return bool | null | string
     */
    public function getAccountId() {
        return $this->scopeConfig->getValue(self::XML_PATH_ACCOUNT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Format Price
     *
     * @return float
     */
    public function formatPrice($price){
        return (float)sprintf('%.2F', $price);
    }



    /**
     * @return string
     */
    public function getDataLayerName(){
        return $this->_dataLayerName;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setDataLayerName($name){
        $this->_dataLayerName = $name;
        return $this;
    }

}
