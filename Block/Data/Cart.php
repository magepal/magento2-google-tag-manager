<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block\Data;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagePal\GoogleTagManager\Block\DataLayer;
use MagePal\GoogleTagManager\Model\Cart as GtmCartModel;
use MagePal\GoogleTagManager\Model\DataLayerEvent;

class Cart extends Template
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
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function _prepareLayout()
    {
        /** @var $tm DataLayer */
        $tm = $this->getParentBlock();

        $data = [
            'event' => DataLayerEvent::CART_PAGE_EVENT,
            'cart' => $this->gtmCart->getCart()
        ];

        $tm->addVariable('list', 'cart');
        $tm->addCustomDataLayerByEvent(DataLayerEvent::CART_PAGE_EVENT, $data);
        return $this;
    }
}
