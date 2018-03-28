<?php
/**
 * Google Tag Manager
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block\Data;

use Magento\Framework\View\Element\Template\Context;
use MagePal\GoogleTagManager\Model\Customer as GtmCustomerModel;

/**
 * Block : Customer Datalayer for un-cached page
 *
 * @package MagePal\GoogleTagManager
 * @class   Customer
 */
class Customer extends \Magento\Framework\View\Element\Template
{
    /**
     * @var GtmCustomerModel
     */
    protected $gtmCustomer;

    /**
     * @param Context $context
     * @param GtmCustomerModel $gtmCustomer
     */
    public function __construct(
        Context $context,
        GtmCustomerModel $gtmCustomer
    ) {
        $this->gtmCustomer = $gtmCustomer;
    }
    /**
     * Add product data to datalayer
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        /** @var $tm \MagePal\GoogleTagManager\Block\DataLayer */
        $tm = $this->getParentBlock();
        $tm->addVariable('customer', $this->gtmCustomer->getCustomer());

        return $this;
    }
}
