<?php

/**
 * DataLayer
 * Copyright © 2016 MagePal. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagePal\GoogleTagManager\Model;

use Magento\Framework\DataObject;

class DataLayer extends DataObject {
    
    /**
     * @var Quote|null
     */
    protected $_quote = null;
    
    /**
     * Datalayer Variables
     * @var array
     */
    protected $_variables = [];

    /**
     * Customer session
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_context;
    
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_checkoutSession;
    
    /**
     * @var string
     */
    protected $_fullActionName;


    /**
     * @param MessageInterface $message
     * @param null $parameters
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context, 
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, 
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Registry $registry
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_customerSession = $customerSession;
        $this->_context = $context;
        $this->_coreRegistry = $registry;
        $this->_checkoutSession = $checkoutSession;
        
        $this->fullActionName = $this->_context->getRequest()->getFullActionName();
        
        $this->addVariable('pageType', $this->fullActionName);
        $this->addVariable('list', 'other');
        
        $this->setCustomerDataLayer();
        $this->setProductDataLayer();
        $this->setCategoryDataLayer();
        $this->setCartDataLayer();
        
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
     * Add Variables
     * @param string $name
     * @param mix $value
     * @return MagePal\GoogleTagManager\Model\DataLayer
     */
    public function addVariable($name, $value) {

        if (!empty($name)) {
            $this->_variables[$name] = $value;
        }

        return $this;
    }

    
    /**
     * Set category Data Layer
     */
    protected function setCategoryDataLayer() {
        if($this->fullActionName === 'catalog_category_view'
           && $_category = $this->_coreRegistry->registry('current_category')
        ) {
                $category = [];
                $category['id'] = $_category->getId();
                $category['name'] = $_category->getName();
                
                $this->addVariable('category', $category);
                
                $this->addVariable('list', 'category');
        }

        return $this;
    }
    
    
    /**
     * Set product Data Layer
     */
    protected function setProductDataLayer() {
        if($this->fullActionName === 'catalog_product_view'
           && $_product = $this->_coreRegistry->registry('current_product')
        ) {
            $this->addVariable('list', 'detail');

            $product = [];
            $product['id'] = $_product->getId();
            $product['sku'] = $_product->getSku();
            $product['name'] = $_product->getName();
            // $this->addVariable('productPrice', $_product->getPrice());
            $this->addVariable('product', $product);
        }

        return $this;
    }

    /**
     * Set Customer Data Layer
     */
    protected function setCustomerDataLayer() {
        $customer = [];
        if ($this->_customerSession->isLoggedIn()) {
            $customer['isLoggedIn'] = true;
            $customer['id'] = $this->_customerSession->getCustomerId();
            $customer['groupId'] = $this->_customerSession->getCustomerGroupId();
            //$customer['groupCode'] = ;
        } else {
            $customer['isLoggedIn'] = false;
        }
        
        $this->addVariable('customer', $customer);

        return $this;
    }
    
    
    /**
     * Set cart Data Layer
     */
    protected function setCartDataLayer() {
        if($this->fullActionName === 'checkout_index_index'){
            $this->addVariable('list', 'cart');
        }
        
        $quote = $this->getQuote();
        $cart = [];
        
        $cart['hasItems'] = false;

        if ($quote->getItemsCount()) {
            $items = [];
            // set items
            foreach($quote->getAllVisibleItems() as $item){
                $items[] = [
                    'sku' => $item->getSku(),
                    'name' => $item->getName(),
                    'price' => $item->getPrice(),
                    'quantity' => $item->getQty()
                ];
            }
            
            if(count($items) > 0){
                $cart['hasItems'] = true;
                $cart['items'] = $items; 
            }
            
            $cart['total'] = $quote->getGrandTotal();
            $cart['itemCount'] = $quote->getItemsCount();
            
            
            //set coupon code
            $coupon = $quote->getCouponCode();
            
            $cart['hasCoupons'] = $coupon ? true : false;

            if($coupon){
                $cart['couponCode'] = $coupon;
            }
        }
        
        $this->addVariable('cart', $cart);
        
        return $this;
    }
    
    
    /**
     * Get active quote
     *
     * @return Quote
     */
    public function getQuote()
    {
        if (null === $this->_quote) {
            $this->_quote = $this->_checkoutSession->getQuote();
        }
        return $this->_quote;
    }
    
    /**
     * Format Price
     *
     * @return float
     */
    public function formatPrice($price){
        return sprintf('%.2F', $price);
    }

}
