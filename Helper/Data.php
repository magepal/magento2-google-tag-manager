<?php
/**
 * Google Tag Manager
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ACTIVE = 'googletagmanager/general/active';
    const XML_PATH_ACCOUNT = 'googletagmanager/general/account';
    const XML_PATH_DATALAYER_NAME = 'googletagmanager/general/datalayer_name';

    protected $_dataLayerName = 'dataLayer';

    /**
     * Whether Tag Manager is ready to use
     *
     * @param null $store_id
     * @return bool
     */
    public function isEnabled($store_id = null)
    {
        $accountId = $this->scopeConfig->getValue(
            self::XML_PATH_ACCOUNT,
            ScopeInterface::SCOPE_STORE,
            $store_id
        );

        $active = $this->scopeConfig->isSetFlag(
            self::XML_PATH_ACTIVE,
            ScopeInterface::SCOPE_STORE,
            $store_id
        );

        return $accountId && $active;
    }

    /**
     * Get Tag Manager Account ID
     *
     * @param null $store_id
     * @return bool | null | string
     */
    public function getAccountId($store_id = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ACCOUNT,
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
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
     * @param null $store_id
     * @return string
     */
    public function getDataLayerName($store_id = null)
    {
        if (!$this->_dataLayerName) {
            $this->_dataLayerName = $this->scopeConfig->getValue(
                self::XML_PATH_DATALAYER_NAME,
                ScopeInterface::SCOPE_STORE,
                $store_id
            );
        }
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
