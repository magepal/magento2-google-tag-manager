<?php
/**
 * Google Tag Manager
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagePal\GoogleTagManager\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ACTIVE = 'googletagmanager/general/active';
    const XML_PATH_ACCOUNT = 'googletagmanager/general/account';

    protected $_dataLayerName = 'dataLayer';

    /**
     * Whether Tag Manager is ready to use
     *
     * @return bool
     */
    public function isEnabled()
    {
        $accountId = $this->scopeConfig->getValue(self::XML_PATH_ACCOUNT, ScopeInterface::SCOPE_STORE);
        $active = $this->scopeConfig->isSetFlag(self::XML_PATH_ACTIVE, ScopeInterface::SCOPE_STORE);
        return $accountId && $active;
    }

    /**
     * Get Tag Manager Account ID
     *
     * @return bool | null | string
     */
    public function getAccountId()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ACCOUNT, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Format Price
     *
     * @param $price
     * @return float
     */
    public function formatPrice($price)
    {
        return (float)sprintf('%.2F', $price);
    }

    /**
     * @return string
     */
    public function getDataLayerName()
    {
        return $this->_dataLayerName;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setDataLayerName($name)
    {
        $this->_dataLayerName = $name;
        return $this;
    }
}
