/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * https://www.magepal.com | support@magepal.com
 */

define([
    'Magento_Customer/js/customer-data',
    'jquery',
    'underscore',
    'mage/cookies'
], function (customerData, $, _) {
    'use strict';

    var lastPushedCart = {};
    var lastPushedCustomer = {};

    //check if object contain keys
    function objectKeyExist(object)
    {
        return _.some(object, function (o) {
            return !_.isEmpty(_.pick(o, ['customer', 'cart']));
        })
    }

    //Update datalayer
    function updateDataLayer(_gtmDataLayer, _dataObject, _forceUpdate)
    {
        var customer = {isLoggedIn : false},
            cart = {hasItems: false};

        if (_gtmDataLayer !== undefined && (!objectKeyExist(_gtmDataLayer) || _forceUpdate)) {
            if (_.isObject(_dataObject) && _.has(_dataObject, 'customer')) {
                customer = _dataObject.customer;
            }

            if (_.isObject(_dataObject) && _.has(_dataObject, 'cart')) {
                cart = _dataObject.cart;
            }

            if (!_.isEqual(lastPushedCart, cart) || !_.isEqual(lastPushedCustomer, customer)) {
                $('body').trigger('mpCustomerSession', [customer, cart, _gtmDataLayer]);
                _gtmDataLayer.push({'event': 'mpCustomerSession', 'customer': customer, 'cart': cart});

                lastPushedCustomer = customer;
                lastPushedCart = cart;
            }
        }
    }

    function isTrackingAllowed(config)
    {
        var allowServices = false,
            allowedCookies,
            allowedWebsites,
            cookieGroupSettings,
            allowedCookieGroupSettings;

        if (!config.isGdprEnabled || (!config.isGdprEnabled && !config.addJsInHeader)) {
            allowServices = true;
        } else if (config.isCookieRestrictionModeEnabled && config.gdprOption === 1) {
            allowedCookies = $.mage.cookies.get(config.cookieName);

            if (allowedCookies !== null) {
                allowedWebsites = JSON.parse(allowedCookies);

                if (allowedWebsites[config.currentWebsite] === 1) {
                    allowServices = true;
                }
            }
        } else if (config.gdprOption === 2) {
            allowServices = $.mage.cookies.get(config.cookieName) !== null;
        } else if (config.gdprOption === 3) {
            allowServices = $.mage.cookies.get(config.cookieName) === null;
        } else if (config.gdprOption === 4) {
            cookieGroupSettings = $.mage.cookies.get(config.cookieName);

            if (cookieGroupSettings !== null) {

                // Check if JSON
                if (isJSON(cookieGroupSettings)) {

                    allowedCookieGroupSettings = JSON.parse(cookieGroupSettings);

                    // If accept all is expected to be an array
                    if (config.cookieGroupAcceptAll.trim() !== '' && config.cookieGroupAcceptAllValue.trim() !== '') {
                        // Check array key as string or int
                        if (allowedCookieGroupSettings[config.cookieGroupAcceptAll] == config.cookieGroupAcceptAllValue ||
                            allowedCookieGroupSettings[parseInt(config.cookieGroupAcceptAll)] == config.cookieGroupAcceptAllValue) {
                            return config.cookieGroupNameNegate == 0 ? 'true' : 'false';
                        }
                    }
                    // If accept all is not expected to be an array
                    else if (config.cookieGroupAcceptAll.trim() !== '' && config.cookieGroupAcceptAllValue.trim() === '') {
                        if (allowedCookieGroupSettings == config.cookieGroupAcceptAll) {
                            return config.cookieGroupNameNegate == 0 ? 'true' : 'false';
                        }
                    }

                    if (config.cookieGroupNameValue.trim() !== '') {
                        // Check array key as string or int
                        if (allowedCookieGroupSettings[config.cookieGroupName] == config.cookieGroupNameValue ||
                            allowedCookieGroupSettings[parseInt(config.cookieGroupName)] == config.cookieGroupNameValue) {
                            allowServices = config.cookieGroupNameNegate == 0 ? 'true' : 'false';
                        }
                    } else {
                        if (allowedCookieGroupSettings.includes(config.cookieGroupName)) {
                            allowServices = config.cookieGroupNameNegate == 0 ? 'true' : 'false';
                        }
                    }
                } else {
                    // Assume comma separated list
                    const cookieArray = cookieGroupSettings.split(",");

                    if (cookieArray.includes(config.cookieGroupName) || cookieArray.includes(config.cookieGroupAcceptAll)) {
                        allowServices = config.cookieGroupNameNegate == 0 ? 'true' : 'false';
                    }
                }
            }
        }

        return allowServices;
    }

    //load gtm
    function initTracking(dataLayerName, accountId, containerCode)
    {
        $(document).trigger('gtm:beforeInitialize');

        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != dataLayerName ? '&l=' + l : '';
            j.async = true;
            j.src = '//www.googletagmanager.com/gtm.js?id=' + i + dl + containerCode;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', dataLayerName, accountId);

        $(document).trigger('gtm:afterInitialize');
    }

    function pushData(dataLayerName, dataLayer)
    {
        if (_.isArray(dataLayer)) {
            _.each(dataLayer, function (data) {
                window[dataLayerName].push(data);
            });
        }
    }

    return function (config) {

        window[config.dataLayer] = window[config.dataLayer] || [];

        if (_.has(config, 'accountId') && isTrackingAllowed(config)) {
            initTracking(config.dataLayer, config.accountId, config.containerCode);
            pushData(config.dataLayer, config.data);
        }

        var dataObject = customerData.get('magepal-gtm-jsdatalayer');
        var gtmDataLayer = window[config.dataLayer];


        dataObject.subscribe(function (_dataObject) {
            updateDataLayer(gtmDataLayer, _dataObject, true);
        }, this);

        if (!_.contains(customerData.getExpiredKeys(), 'magepal-gtm-jsdatalayer')) {
            updateDataLayer(gtmDataLayer, dataObject(), false);
        }

    }

    function isJSON(str) {
        try {
            return (JSON.parse(str) && !!str);
        } catch (e) {
            return false;
        }
    }

});
