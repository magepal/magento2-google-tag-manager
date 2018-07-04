<?php
/**
 * Google Tag Manager
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block\Data;

use Magento\Framework\View\Element\Template\Context;

/**
 * Block : Datalayer for order success page
 *
 * @package MagePal\GoogleTagManager
 * @class   Order
 * @method Array setOrderIds(Array $orderIds)
 * @method Array getOrderIds()
 */
class Order extends \Magento\Framework\View\Element\Template
{
    /** @var \MagePal\GoogleTagManager\Model\Order */
    protected $orderDataArray;

    /**
     * @param Context $context
     * @param \MagePal\GoogleTagManager\Model\Order $orderDataArray
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \MagePal\GoogleTagManager\Model\Order $orderDataArray,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->orderDataArray = $orderDataArray;
    }

    /**
     * Render information about specified orders and their items
     *
     * @return void|string
     */
    public function addOrderLayer()
    {
        $transactions = $this->orderDataArray->setOrderIds($this->getOrderIds())->getOrderLayer();

        if (!empty($transactions)) {
            /** @var $tm \MagePal\GoogleTagManager\Block\DataLayer */
            $tm = $this->getParentBlock();
            foreach ($transactions as $order) {
                $tm->addAdditionalVariable($order);
            }
        }
    }
}
