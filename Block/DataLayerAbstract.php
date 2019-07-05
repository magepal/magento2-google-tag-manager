<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block;

use Magento\Cookie\Helper\Cookie as CookieHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagePal\GoogleTagManager\Helper\Data as GtmHelper;

/**
 * Class DataLayerAbstract
 * @package MagePal\GoogleTagManager\Block
 * @method getList()
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
     * @var array
     */
    protected $_variables = [];

    /**
     * Cookie Helper
     *
     * @var CookieHelper
     */
    protected $_cookieHelper = null;

    /**
     * @param Context $context
     * @param GtmHelper $gtmHelper
     * @param CookieHelper $cookieHelper
     * @param array $data
     * @throws NoSuchEntityException
     */
    public function __construct(
        Context $context,
        GtmHelper $gtmHelper,
        CookieHelper $cookieHelper,
        array $data = []
    ) {
        $this->_gtmHelper = $gtmHelper;
        parent::__construct($context, $data);
        $this->_cookieHelper = $cookieHelper;
        $this->_init();
    }

    /**
     * @return $this
     * @throws NoSuchEntityException
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

        $result = [];

        if (!empty($this->getVariables())) {
            $result[] = $this->getVariables();
        }

        if (!empty($this->_additionalVariables) && is_array($this->_additionalVariables)) {
            foreach ($this->_additionalVariables as $custom) {
                $result[] = $custom;
            }
        }

        return json_encode($result);
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

    /**
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getStoreCurrencyCode()
    {
        return $this->_storeManager->getStore()->getCurrentCurrency()->getCode();
    }

    /**
     * Return cookie restriction mode value.
     *
     * @return bool
     */
    public function isCookieRestrictionModeEnabled()
    {
        return (int) $this->_cookieHelper->isCookieRestrictionModeEnabled();
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
