<?php

/**
 * Google Tag Manager
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block;

/**
 * Google Tag Manager Block
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

        /** @var $blockOnepageOrder \MagePal\GoogleTagManager\Block\Data\Order */
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
}
