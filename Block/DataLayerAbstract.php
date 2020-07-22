<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagePal\GoogleTagManager\Helper\Data as GtmHelper;

/**
 * @method getList()
 * @method setListType()
 * @method getListType()
 */
class DataLayerAbstract extends Template
{

    /**
     * @var GtmHelper
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

    /**
     * Push elements last to the data layer
     * @var array
     */
    protected $customVariables = [];

    /**
     * @var array
     */
    protected $_variables = [];

    /**
     * @param Context $context
     * @param GtmHelper $gtmHelper
     * @param array $data
     * @throws NoSuchEntityException
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
     * @throws NoSuchEntityException
     */
    protected function _init()
    {
        $this->addVariable('ecommerce', ['currencyCode' => $this->getStoreCurrencyCode()]);
        $this->addVariable('pageType', $this->_request->getFullActionName());
        $this->addVariable('list', 'other');

        return $this;
    }

    /**
     * Return data layer json
     *
     * @return array
     */
    public function getDataLayer()
    {
        $this->_eventManager->dispatch(
            $this->dataLayerEventName,
            ['dataLayer' => $this]
        );

        $result = [];

        if (!empty($this->getVariables())) {
            $result[] = $this->getVariables();
        }

        if (!empty($this->_additionalVariables) && is_array($this->_additionalVariables)) {
            foreach ($this->_additionalVariables as $custom) {
                $result[] = $custom;
            }
        }

        if (!empty($this->customVariables)) {
            ksort($this->customVariables);
            foreach ($this->customVariables as $priorityVariable) {
                foreach ($priorityVariable as $data) {
                    $result[] = $data;
                }
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getDataLayerJson()
    {
        return json_encode($this->getDataLayer());
    }

    /**
     * @return string
     */
    public function getDataLayerJs()
    {
        $result = [];

        foreach ($this->getDataLayer() as $data) {
            $result[] = sprintf("window.%s.push(%s);\n", $this->getDataLayerName(), json_encode($data));
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
     * @deprecated - use addCustomDataLayer and addCustomDataLayerByEvent
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
     * Add variable to the custom push data layer
     *
     * @param  array  $data
     * @param  int  $priority
     * @param  null  $group
     * @return $this
     */
    public function addCustomDataLayer($data, $priority = 0, $group = null)
    {
        $priority = (int) $priority;

        if (is_array($data) && empty($group)) {
            $this->customVariables[$priority][] = $data;
        } elseif (is_array($data) && !empty($group)) {
            if (array_key_exists($priority, $this->customVariables)
                && array_key_exists($group, $this->customVariables[$priority])
            ) {
                $this->customVariables[$priority][$group] = array_merge(
                    $this->customVariables[$priority][$group],
                    $data
                );
            } else {
                $this->customVariables[$priority][$group] =  $data;
            }
        }

        return $this;
    }

    /**
     * @param $event
     * @param $data
     * @param  int  $priority
     * @return $this
     */
    public function addCustomDataLayerByEvent($event, $data, $priority = 20)
    {
        if (!empty($event)) {
            $data['event'] = $event;
            $this->addCustomDataLayer($data, $priority, $event);
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

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getStoreCurrencyCode()
    {
        return $this->_storeManager->getStore()->getCurrentCurrency()->getCode();
    }

    /**
     * Return cookie restriction mode value.
     *
     * @return int
     */
    public function isCookieRestrictionModeEnabled()
    {
        return (int) $this->_gtmHelper->isCookieRestrictionModeEnabled();
    }
    /**
     * Return current website id.
     *
     * @return int
     * @throws LocalizedException
     */
    public function getCurrentWebsiteId()
    {
        return $this->_storeManager->getWebsite()->getId();
    }
}
