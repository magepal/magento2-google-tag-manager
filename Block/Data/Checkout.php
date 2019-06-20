<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block\Data;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagePal\GoogleTagManager\Block\DataLayer;
use MagePal\GoogleTagManager\Model\Cart as GtmCartModel;

/**
 * Class Checkout
 * @package MagePal\GoogleTagManager\Block\Data
 */
class Checkout extends Template
{

    /**
     * @var GtmCartModel
     */
    protected $gtmCart;

    /**
     * @param Context $context
     * @param GtmCartModel $gtmCart
     * @param array $data
     */
    public function __construct(
        Context $context,
        GtmCartModel $gtmCart,
        $data = []
    ) {
        $this->gtmCart = $gtmCart;
        parent::__construct($context, $data);
    }

    /**
     * Add product data to datalayer
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        /** @var $tm DataLayer */
        $tm = $this->getParentBlock();

        $tm->addVariable('cart', $this->gtmCart->getCart());
        $tm->addVariable('event', 'checkoutPage');

        return $this;
    }
}
