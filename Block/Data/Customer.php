<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block\Data;

use Magento\Framework\View\Element\Template\Context;
use MagePal\GoogleTagManager\Model\Customer as GtmCustomerModel;

/**
 * Class Customer
 * @package MagePal\GoogleTagManager\Block\Data
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
     * @param array $data
     */
    public function __construct(
        Context $context,
        GtmCustomerModel $gtmCustomer,
        array $data = []
    ) {
        $this->gtmCustomer = $gtmCustomer;
        parent::__construct($context, $data);
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
