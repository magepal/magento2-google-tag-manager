<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * Active flag
     */
    const XML_PATH_ACTIVE = 'googletagmanager/general/active';

    /**
     * Account number
     */
    const XML_PATH_ACCOUNT = 'googletagmanager/general/account';

    /**
     * Datalayer name
     */
    const XML_PATH_DATALAYER_NAME = 'googletagmanager/general/datalayer_name';

    /**
     * Path to configuration, check is enable cookie restriction mode
     */
    const XML_PATH_COOKIE_RESTRICTION = 'web/cookie/cookie_restriction';

    /**
     * @var string
     */
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
     * @param null $store_id
     * @return string
     */
    public function getCookieRestrictionName($store_id = null)
    {
        return $this->scopeConfig->getValue(
            'googletagmanager/gdpr/restriction_cookie_name',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * @param null $store_id
     * @return bool
     */
    public function isGdprEnabled($store_id = null)
    {
        return $this->scopeConfig->isSetFlag(
            'googletagmanager/gdpr/enabled',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * @param null $store_id
     * @return int
     */
    public function getGdprOption($store_id = null)
    {
        return (int) $this->scopeConfig->getValue(
            'googletagmanager/gdpr/option',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * @param null $store_id
     * @return int
     */
    public function addJsInHead($store_id = null)
    {
        return (int) $this->scopeConfig->isSetFlag(
            'googletagmanager/gdpr/add_js_in_header',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * Check if cookie restriction mode is enabled for this store
     * Fix issue in 2.1.9
     * @return bool
     */
    public function isCookieRestrictionModeEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_COOKIE_RESTRICTION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Tag Manager Account ID
     *
     * @param null $store_id
     * @return null | string
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
