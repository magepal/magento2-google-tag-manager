<?php
/**
 * Google Tag Manager
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Model;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\DataObject;
use MagePal\GoogleTagManager\Helper\Data as GtmHelper;

class Cart extends DataObject
{

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var GtmHelper
     */
    protected $gtmHelper;

    /**
     * Escaper
     *
     * @var \Magento\Framework\Escaper
     */
    protected $_escaper;

    /**
     * Cart constructor.
     * @param CheckoutSession $checkoutSession
     * @param GtmHelper $gtmHelper
     * @param array $data
     */
    public function __construct(
        CheckoutSession $checkoutSession,
        GtmHelper $gtmHelper,
        \Magento\Framework\Escaper $escaper,
        array $data = []
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->gtmHelper = $gtmHelper;
        $this->_escaper = $escaper;
        parent::__construct($data);
    }

    /**
     * Get cart array
     *
     * @return array
     */
    public function getCart()
    {
        $quote = $this->getQuote();

        $cart = [];

        $cart['hasItems'] = false;

        if ($quote->getItemsCount()) {
            $items = [];
            // set items
            foreach ($quote->getAllVisibleItems() as $item) {
                $items[] = [
                    'sku' => $item->getSku(),
                    'name' => $this->escapeJsQuote($item->getName()),
                    'price' => $this->gtmHelper->formatPrice($item->getPrice()),
                    'quantity' => $item->getQty(),
                ];
            }

            if (count($items) > 0) {
                $cart['hasItems'] = true;
                $cart['items'] = $items;
            }

            $cart['total'] = $this->gtmHelper->formatPrice($quote->getGrandTotal());
            $cart['itemCount'] = $quote->getItemsCount() * 1;
            $cart['cartQty'] = $quote->getItemsQty() * 1;

            //set coupon code
            $coupon = $quote->getCouponCode();

            $cart['hasCoupons'] = $coupon ? true : false;

            if ($coupon) {
                $cart['couponCode'] = $coupon;
            }
        }

        return $cart;
    }

    /**
     * Get active quote
     *
     * @return \Magento\Quote\Model\Quote
     */
    public function getQuote()
    {
        return $this->checkoutSession->getQuote();
    }

    /**
     * Escape quotes in java scripts
     *
     * @param string|array $data
     * @param string $quote
     * @return string|array
     */
    public function escapeJsQuote($data, $quote = '\'')
    {
        return $this->_escaper->escapeJsQuote($data, $quote);
    }
}
