<?php
/**
 * Blocks feeding datalayer
 *
 * @category  MagePal
 * @package   MagePal\GoogleTagManager
 * @author    Pascal Noisette <netpascal0123@aol.com>
 * @copyright 2017
 */
namespace MagePal\GoogleTagManager\Block\Data\Session;


/**
 * Block : Customer for all page
 *
 * @package MagePal\GoogleTagManager
 * @class   Customer
 */
class Customer extends \MagePal\GoogleTagManager\Block\Data\Session
{
    /**
     * Add product data to datalayer
     *
     * @return $this
     */
    function _prepareLayout()
    {
        /** @var $tm \MagePal\GoogleTagManager\Block\Tm */
        $tm = $this->getParentBlock();

        if ($this->pageIsCachable() || !$this->customerSession->isLoggedIn()) {
            $tm->addVariable('customer', ['isLoggedIn'=>false]);
        } else {
            $tm->addVariable(
                'customer', [
                    'isLoggedIn' => true,
                    'id' => $this->customerSession->getCustomerId(),
                    'groupId' => $this->customerSession->getCustomerGroupId()
                ]
            );
        }
    }
}
