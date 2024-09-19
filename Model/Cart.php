<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * https://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Model;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\DataObject;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote;
use MagePal\GoogleTagManager\DataLayer\QuoteData\QuoteItemProvider;
use MagePal\GoogleTagManager\DataLayer\QuoteData\QuoteProvider;
use MagePal\GoogleTagManager\Helper\DataLayerItem as dataLayerItemHelper;

class Cart extends DataObject
{

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var dataLayerItemHelper
     */
    protected $dataLayerItemHelper;

    /**
     * Escaper
     *
     * @var Escaper
     */
    protected $_escaper;

    /**
     * @var QuoteProvider
     */
    protected $quoteProvider;

    /**
     * @var QuoteItemProvider
     */
    protected $quoteItemProvider;

    /**
     * Cart constructor.
     * @param CheckoutSession $checkoutSession
     * @param dataLayerItemHelper $dataLayerItemHelper
     * @param Escaper $escaper
     * @param QuoteProvider $quoteProvider
     * @param QuoteItemProvider $quoteItemProvider
     * @param array $data
     */
    public function __construct(
        CheckoutSession $checkoutSession,
        dataLayerItemHelper $dataLayerItemHelper,
        Escaper $escaper,
        QuoteProvider $quoteProvider,
        QuoteItemProvider $quoteItemProvider,
        array $data = []
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->dataLayerItemHelper = $dataLayerItemHelper;
        $this->_escaper = $escaper;
        $this->quoteProvider = $quoteProvider;
        $this->quoteItemProvider = $quoteItemProvider;
        parent::__construct($data);
    }

    /**
     * Get cart array
     *
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getCart()
    {
        $quote = $this->getQuote();

        $cart = [];

        $cart['hasItems'] = false;

        if ($quote->getItemsCount()) {
            $items = [];
            foreach ($quote->getAllVisibleItems() as $item) {
                $itemData = [
                    'sku' => $item->getSku(),
                    'parent_sku' => $item->getProduct() ? $item->getProduct()->getData('sku') : $item->getSku(),
                    'name' => $item->getName(),
                    'product_type' => $item->getProductType(),
                    'price' => $this->dataLayerItemHelper->formatPrice($item->getPrice()),
                    'price_incl_tax' => $this->dataLayerItemHelper->formatPrice($item->getPriceInclTax()),
                    'discount_amount' => $this->dataLayerItemHelper->formatPrice($item->getDiscountAmount()),
                    'tax_amount' => $this->dataLayerItemHelper->formatPrice($item->getTaxAmount()),
                    'quantity' => $item->getQty() * 1,
                ];

                if ($variant = $this->dataLayerItemHelper->getItemVariant($item)) {
                    $itemData['variant'] = $variant;
                }

                if (!empty($category = $this->dataLayerItemHelper->getCategories($item))) {
                    $itemData['categories'] = $category;
                    $itemData['category'] = $this->dataLayerItemHelper->getFirstCategory($item);
                }

                $items[] = $this->quoteItemProvider
                                ->setItem($item)
                                ->setItemData($itemData)
                                ->setActionType(QuoteItemProvider::ACTION_VIEW_CART)
                                ->setListType(QuoteItemProvider::LIST_TYPE_GENERIC)
                                ->getData();
            }

            if (count($items) > 0) {
                $cart['hasItems'] = true;
                $cart['items'] = $items;
            }

            $cart['total'] = $this->dataLayerItemHelper->formatPrice($quote->getGrandTotal());
            $cart['itemCount'] = $quote->getItemsCount() * 1;
            $cart['cartQty'] = $quote->getItemsQty() * 1;

            //set coupon code
            $coupon = $quote->getCouponCode();

            $cart['hasCoupons'] = $coupon ? true : false;

            if ($coupon) {
                $cart['couponCode'] = $coupon;
            }
        }

        return $this->quoteProvider->setQuote($this->getQuote())->setTransactionData($cart)->getData();
    }

    /**
     * Get active quote
     *
     * @return Quote
     * @throws LocalizedException
     * @throws NoSuchEntityException
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
