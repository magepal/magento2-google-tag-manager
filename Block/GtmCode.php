<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagePal\GoogleTagManager\Helper\Data as GtmHelper;

class GtmCode extends Template
{
    /**
     * @var GtmHelper
     */
    protected $_gtmHelper = null;

    /**
     * @param Context $context
     * @param GtmHelper $gtmHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        GtmHelper $gtmHelper,
        array $data = []
    ) {
        $this->_gtmHelper = $gtmHelper;
        parent::__construct($context, $data);
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
     * @return string
     */
    public function getDataLayerName()
    {
        return $this->_gtmHelper->getDataLayerName();
    }

    /**
     * @return string
     */
    public function getEmbeddedAccountId()
    {
        return $this->_gtmHelper->isMultiContainerEnabled() ?
            $this->getAccountId() . $this->_gtmHelper->getMultiContainerCode() : $this->getAccountId();
    }

    /**
     * If the GTM should be loaded externally by an third party,
     * like an GDPR service, this function will return true
     * and false otherwise
     * 
     * @return bool
     */
    public function isExternal(){
        return $this->_gtmHelper->isExternal();
    }

    /**
     * Render tag manager JS
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->_gtmHelper->isEnabled()) {
            return '';
        }

        return parent::_toHtml();
    }
}
