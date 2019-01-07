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
], function (customerData, $, _) {
    'use strict';

    var lastPushedCart = {};
    var lastPushedCustomer = {};

    function objectKeyExist(object) {
        return _.some(object, function (o) {
            return !_.isEmpty(_.pick(o, ["customer", "cart"]));
        })
    }

    function updateDataLayer(_gtmDataLayer, _dataObject, _forceUpdate) {
        var customer = {isLoggedIn: false},
            cart = {hasItems: false};

        if (_gtmDataLayer !== undefined && (!objectKeyExist(_gtmDataLayer) || _forceUpdate)) {
            if (_.isObject(_dataObject) && _.has(_dataObject, 'customer')) {
                customer = _dataObject.customer;
            }

            if (_.isObject(_dataObject) && _.has(_dataObject, 'cart')) {
                cart = _dataObject.cart;
            }

            if (!_.isEqual(lastPushedCart, cart) || !_.isEqual(lastPushedCustomer, customer)) {
                _gtmDataLayer.push({"event": 'mpCustomerSession', "customer": customer, "cart": cart});

                lastPushedCustomer = customer;
                lastPushedCart = cart;
            }

        }
    }

    return function (config) {
        var allowServices = false,
            allowedCookies,
            allowedWebsites;

        if (config.isCookieRestrictionModeEnabled) {
            allowedCookies = $.mage.cookies.get(config.cookieName);

            if (allowedCookies !== null) {
                allowedWebsites = JSON.parse(allowedCookies);

                if (allowedWebsites[config.currentWebsite] === 1) {
                    allowServices = true;
                }
            }
        } else {
            allowServices = true;
        }

        if (allowServices === false) {
            return;
        }
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = '//www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', config.dataLayer, config.accountId);

        var dataObject = customerData.get("magepal-gtm-jsdatalayer");

        var gtmDataLayer = window[config.dataLayer];


        dataObject.subscribe(function (_dataObject) {
            updateDataLayer(gtmDataLayer, _dataObject, true);
        }, this);

        if (!_.contains(customerData.getExpiredKeys(), "magepal-gtm-jsdatalayer")) {
            updateDataLayer(gtmDataLayer, dataObject(), false);
        }

    }

});