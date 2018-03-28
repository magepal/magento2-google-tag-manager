/**
 * Google Tag Manager
 *
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

define([
    'Magento_Customer/js/customer-data',
    'jquery',
    'underscore'
], function(customerData, $, _){
    'use strict';

    var lastPushedCart = {};
    var lastPushedCustomer = {};

    function objectKeyExist(object){
        return _.some(object, function(o) {
            return !_.isEmpty(_.pick(o, ["customer", "cart"]));
        })
    }

    function updateDataLayer(_gtmDataLayer, _dataObject, _forceUpdate){
        var customer = {isLoggedIn : false},
            cart = {hasItems : false};

        if(_gtmDataLayer !== undefined && (!objectKeyExist(_gtmDataLayer) || _forceUpdate)){
            if(_.isObject(_dataObject) && _.has(_dataObject, 'customer')){
                customer = _dataObject.customer;
            }

            if(_.isObject(_dataObject) &&_.has(_dataObject, 'cart')){
                cart = _dataObject.cart;
            }

            if(!_.isEqual(lastPushedCart, cart) || !_.isEqual(lastPushedCustomer, customer)){
                _gtmDataLayer.push({"event": 'mpCustomerSession', "customer" : customer, "cart" : cart});

                lastPushedCustomer = customer;
                lastPushedCart = cart;
            }

        }
    }

    return function (options) {
        var dataObject = customerData.get("magepal-gtm-jsdatalayer");

        var gtmDataLayer = window[options.dataLayer];


        dataObject.subscribe(function (_dataObject) {
            updateDataLayer(gtmDataLayer, _dataObject, true);
        }, this);

        if(!_.contains(customerData.getExpiredKeys(), "magepal-gtm-jsdatalayer")){
            updateDataLayer(gtmDataLayer, dataObject(), false);
        }

    }

});