<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Model;

use Magento\Customer\Model\Session;
use Magento\Framework\DataObject;

class Customer extends DataObject
{

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * Customer constructor.
     * @param Session $customerSession
     * @param array $data
     */
    public function __construct(
        Session $customerSession,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        parent::__construct($data);
    }

    /**
     * Get Customer array
     *
     * @return array
     */
    public function getCustomer()
    {
        $isLoggedIn = $this->getCustomerSession()->isLoggedIn();
        $data = [
            'isLoggedIn' => $isLoggedIn,
        ];

        if ($isLoggedIn) {
            $data['id'] = $this->getCustomerSession()->getCustomerId();
            $data['groupId'] = $this->getCustomerSession()->getCustomerGroupId();
        }

        return $data;
    }

    /**
     * @return Session
     */
    public function getCustomerSession()
    {
        return $this->customerSession;
    }
}
