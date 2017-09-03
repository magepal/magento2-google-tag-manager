<?php

/**
 * Google Tag Manager
 *
 * Copyright © 2017 MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagePal\GoogleTagManager\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MagePal\GoogleTagManager\Helper\Data as GtmHelper;


/**
 * Google Tag Manager Block
 */
class DataLayer extends Template {

    /**
     * Google Tag Manager Helper
     *
     * @var \MagePal\GoogleTagManager\Helper\Data
     */
    protected $_gtmHelper;


    /**
     * @var array
     */
    protected $_additionalVariables = [];


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
    protected function _init(){
        $this->addVariable('ecommerce', ['currencyCode' => $this->_storeManager->getStore()->getCurrentCurrency()->getCode()]);
        $this->addVariable('pageType', $this->_request->getFullActionName());
        $this->addVariable('list', 'other');
        return $this;
    }


    /**
     * Render tag manager script
     *
     * @return string
     */
    protected function _toHtml() {
        if (!$this->_gtmHelper->isEnabled()) {
            return '';
        }

        /** @var $blockOnepageOrder \MagePal\GoogleTagManager\Block\Data\Order */
        if($this->getOrderIds() && $blockOnepageOrder = $this->getChildBlock("magepal_gtm_block_order")){
            $blockOnepageOrder->setOrderIds($this->getOrderIds())->addOrderLayer();
        }

        return parent::_toHtml();
    }

    /**
     * Get Account Id
     *
     * @return string
     */
    public function getAccountId() {
        return $this->_gtmHelper->getAccountId();
    }

    /**
     * Return data layer json
     *
     * @return json
     */
    public function getDataLayer() {
        $this->_eventManager->dispatch(
            'magepal_datalayer',
            ['dataLayer' => $this]
        );

        $result = [];
        $result[] = sprintf("%s.push(%s);\n", $this->getDataLayerName(), json_encode($this->getVariables()));
        
        if(!empty($this->_additionalVariables) && is_array($this->_additionalVariables)){
           
            foreach($this->_additionalVariables as $custom){
                $result[] = sprintf("%s.push(%s);\n", $this->getDataLayerName(), json_encode($custom));
            }
        }
        
        return implode("\n", $result);
    }

    /**
     * Add Variables
     * @param string $name
     * @param mix $value
     * @return $this
     */
    public function addVariable($name, $value) {

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
    public function getVariables() {
        return $this->_variables;
    }


    /**
     * Add variable to the custom push data layer
     *
     * @param $name
     * @param null $value
     * @return $this
     */
    public function addAdditionalVariable($name, $value = null) {
       if(is_array($name)){
          $this->_additionalVariables[] = $name;
       }
       else{
           $this->_additionalVariables[] = [$name => $value];
       }
        
        return $this;
    }

    /**
     * Format Price
     *
     * @return float
     */
    public function formatPrice($price){
        return sprintf('%.2F', $price);
    }

    /**
     * @return string
     */
    public function getDataLayerName(){
        return $this->_gtmHelper->getDataLayerName();
    }


}
