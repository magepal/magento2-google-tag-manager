<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Model;

use Magento\Framework\DataObject;

/**
 * Class Customer
 * @package MagePal\GoogleTagManager\Model
 */
class Customer extends DataObject
{

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * Customer constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
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
        $isLoggedIn = $this->customerSession->isLoggedIn();
        $data = [
            'isLoggedIn' => $isLoggedIn,
        ];

        if ($isLoggedIn) {
            $data['id'] = $this->customerSession->getCustomerId();
            $data['groupId'] = $this->customerSession->getCustomerGroupId();
        }

        return $data;
    }
}
