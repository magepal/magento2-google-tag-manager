<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * https://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block\Data;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagePal\GoogleTagManager\Block\DataLayer;

/**
 * @method $this setOrderIds(Array $orderIds)
 * @method Array getOrderIds()
 */
class Order extends Template
{
    /** @var \MagePal\GoogleTagManager\Model\Order */
    protected $orderDataArray;

    /**
     * @param Context $context
     * @param \MagePal\GoogleTagManager\Model\Order $orderDataArray
     * @param array $data
     */
    public function __construct(
        Context $context,
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
     * @throws NoSuchEntityException
     */
    public function addOrderLayer()
    {
        $transactions = $this->orderDataArray->setOrderIds($this->getOrderIds())->getOrderLayer();

        if (!empty($transactions)) {
            /** @var $tm DataLayer */
            $tm = $this->getParentBlock();
            foreach ($transactions as $order) {
                $tm->addCustomDataLayer($order);
            }
        }
    }
}
