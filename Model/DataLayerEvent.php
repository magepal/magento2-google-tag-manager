<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Model;

class DataLayerEvent
{
    const ADD_TO_CART_EVENT = 'addToCart';
    const REMOVE_FROM_CART_EVENT = 'removeFromCart';
    const PRODUCT_IMPRESSION_EVENT = 'productImpression';
    const PRODUCT_DETAIL_EVENT = 'productDetail';
    const REFUND_EVENT = 'refund';
    const PRODUCT_PAGE_EVENT = 'productPage';
    const CHECKOUT_PAGE_EVENT = 'checkoutPage';
    const CATEGORY_PAGE_EVENT = 'categoryPage';
    const CART_PAGE_EVENT = 'cartPage';
    const PURCHASE_EVENT = 'purchase';
    const ORDER_SUCCESS_PAGE_EVENT = 'orderSuccessPage';
    /** @deprecated - GTM_ORDER_COMPLETE_EVENT replace with PURCHASE_EVENT */
    const GTM_ORDER_COMPLETE_EVENT = 'gtm.orderComplete';
    const ALL_PAGE_EVENT = 'allPage';
    const SEARCH_PAGE_EVENT = 'searchPage';
    const HOME_PAGE_EVENT = 'homePage';
}
