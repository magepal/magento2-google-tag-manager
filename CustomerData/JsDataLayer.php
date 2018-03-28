<?php
/**
 * Google Tag Manager
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use MagePal\GoogleTagManager\Model\Cart as GtmCartModel;
use MagePal\GoogleTagManager\Model\Customer as GtmCustomerModel;

class JsDataLayer implements SectionSourceInterface
{
    /**
     * @var GtmCustomerModel
     */
    protected $gtmCustomer;

    /**
     * @var GtmCartModel
     */
    protected $gtmCart;

    /**
     * @param GtmCustomerModel $gtmCustomer
     * @param GtmCartModel $gtmCart
     */
    public function __construct(
        GtmCustomerModel $gtmCustomer,
        GtmCartModel $gtmCart
    ) {
        $this->gtmCustomer = $gtmCustomer;
        $this->gtmCart = $gtmCart;
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function getSectionData()
    {
        return [
            'customer' => $this->gtmCustomer->getCustomer(),
            'cart' => $this->gtmCart->getCart()
        ];
    }
}
