<?php

/**
 * Google Tag Manager
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagePal\GoogleTagManager\Helper\Data as GtmHelper;

/**
 * Google Tag Manager Block
 */
class DataLayerAbstract extends Template
{

    /**
     * Google Tag Manager Helper
     *
     * @var \MagePal\GoogleTagManager\Helper\Data
     */
    protected $_gtmHelper;

    /**
     * @var string
     */
    protected $dataLayerEventName = 'magepal_datalayer';

    /**
     * @var array
     */
    protected $_additionalVariables = [];

    protected $_variables = [];

    /**
     * @param Context $context
     * @param GtmHelper $gtmHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        GtmHelper $gtmHelper,
        array $data = []
    ) {
        $this->_gtmHelper = $gtmHelper;
        parent::__construct($context, $data);
        $this->_init();
    }

    /**
     * @return $this
     */
    protected function _init()
    {
        if ($this->getShowEcommerceCurrencyCode()) {
            $this->addVariable('ecommerce', ['currencyCode' => $this->getStoreCurrencyCode()]);
        }

        $this->addVariable('pageType', $this->_request->getFullActionName());
        $this->addVariable('list', 'other');

        return $this;
    }

    /**
     * Return data layer json
     *
     * @return json
     */
    public function getDataLayer()
    {
        $this->_eventManager->dispatch(
            $this->dataLayerEventName,
            ['dataLayer' => $this]
        );

        if (empty($this->getVariables()) && empty($this->_additionalVariables)) {
            return null;
        }

        $result = [];

        if (!empty($this->getVariables())) {
            $result[] = sprintf("%s.push(%s);\n", $this->getDataLayerName(), json_encode($this->getVariables()));
        }

        if (!empty($this->_additionalVariables) && is_array($this->_additionalVariables)) {
            foreach ($this->_additionalVariables as $custom) {
                $result[] = sprintf("%s.push(%s);\n", $this->getDataLayerName(), json_encode($custom));
            }
        }

        return implode("\n", $result);
    }

    /**
     * Add Variables
     * @param string $name
     * @param string|array $value
     * @return $this
     */
    public function addVariable($name, $value)
    {
        if (!empty($name)) {
            $this->_variables[$name] = $value;
        }

        return $this;
    }

    /**
     * Return Data Layer Variables
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->_variables;
    }

    /**
     * Add variable to the custom push data layer
     *
     * @param $name
     * @param null $value
     * @return $this
     */
    public function addAdditionalVariable($name, $value = null)
    {
        if (is_array($name)) {
            $this->_additionalVariables[] = $name;
        } else {
            $this->_additionalVariables[] = [$name => $value];
        }

        return $this;
    }

    /**
     * Format Price
     *
     * @param $price
     * @return float
     */
    public function formatPrice($price)
    {
        return $this->_gtmHelper->formatPrice($price);
    }

    /**
     * @return string
     */
    public function getDataLayerName()
    {
        if (!$this->getData('data_layer_name')) {
            $this->setData('data_layer_name', $this->_gtmHelper->getDataLayerName());
        }
        return $this->getData('data_layer_name');
    }

    public function getStoreCurrencyCode()
    {
        return $this->_storeManager->getStore()->getCurrentCurrency()->getCode();
    }
}
