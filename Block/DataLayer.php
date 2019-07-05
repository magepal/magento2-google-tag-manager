<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block;

use Magento\Cookie\Helper\Cookie;
use MagePal\GoogleTagManager\Block\Data\Order;
use MagePal\GoogleTagManager\Model\Config\Source\GdprOption;

/**
 * Class DataLayer
 * @package MagePal\GoogleTagManager\Block
 */
class DataLayer extends DataLayerAbstract
{

    /**
     * Render tag manager script
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->_gtmHelper->isEnabled()) {
            return '';
        }

        /** @var $blockOnepageOrder Order */
        if ($this->getOrderIds() && $blockOnepageOrder = $this->getChildBlock("magepal_gtm_block_order")) {
            $blockOnepageOrder->setOrderIds($this->getOrderIds())->addOrderLayer();
        }

        return parent::_toHtml();
    }

    /**
     * Get Account Id
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->_gtmHelper->getAccountId();
    }

    /**
     * @param null $store_id
     * @return int
     */
    public function getGdprOption($store_id = null)
    {
        return $this->_gtmHelper->getGdprOption($store_id);
    }

    /**
     * @param null $store_id
     * @return string
     */
    public function getCookieRestrictionName($store_id = null)
    {
        if ($this->_gtmHelper->getGdprOption($store_id) == GdprOption::USE_COOKIE_RESTRICTION_MODE) {
            return Cookie::IS_USER_ALLOWED_SAVE_COOKIE;
        } else {
            return $this->_gtmHelper->getCookieRestrictionName($store_id) ?
                $this->_gtmHelper->getCookieRestrictionName($store_id) : Cookie::IS_USER_ALLOWED_SAVE_COOKIE;
        }
    }

    /**
     * @param null $store_id
     * @return bool
     */
    public function isGdprEnabled($store_id = null)
    {
        return (int) $this->_gtmHelper->isGdprEnabled($store_id);
    }
}
