<?php
/**
 * Google Tag Manager
 *
 * Copyright © 2017 MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagePal\GoogleTagManager\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use MagePal\GoogleTagManager\Model\Customer as GtmCustomerModel;
use MagePal\GoogleTagManager\Model\Cart as GtmCartModel;

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
     */
    public function __construct(
        GtmCustomerModel $gtmCustomer,
        GtmCartModel $gtmCart
    )
    {
        $this->gtmCustomer = $gtmCustomer;
        $this->gtmCart = $gtmCart;
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {

        return [
            'customer' => $this->gtmCustomer->getCustomer(),
            'cart' => $this->gtmCart->getCart()
        ];
    }

}