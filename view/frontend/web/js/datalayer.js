/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
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

    
    /**
     * The function checks if an object has keys 'customer' and 'cart' and returns true if at least one
     * object in the array has these keys.
     * 
     * @param object - The `object` parameter is an object that contains multiple key-value pairs.
     * @returns a boolean value.
     */
    function objectKeyExist(object)
    {
        return _.some(object, function (o) {
            return !_.isEmpty(_.pick(o, ['customer', 'cart']));
        })
    }

    /**
     * The function `updateDataLayer` updates the Google Tag Manager (GTM) data layer with customer and
     * cart information if the data layer is not already defined or if forced to update.
     * 
     * @param _gtmDataLayer - This parameter represents the Google Tag Manager (GTM) data layer. It is
     * an array used to store data that can be accessed by GTM tags and triggers.
     * @param _dataObject - The `_dataObject` parameter is an object that contains information about
     * the customer and the cart.
     * @param _forceUpdate - A boolean value indicating whether to force an update of the data layer
     * even if it already exists.
     */
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

    /**
     * The function checks if tracking is allowed based on the provided configuration.
     * 
     * @param config - The `config` parameter is an object that contains various configuration options
     * for tracking services. It may have the following properties:
     * @returns the value of the variable "allowServices".
     */
    function isTrackingAllowed(config)
    {
        var allowServices = false,
            allowedCookies,
            allowedWebsites;

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
        }

        return allowServices;
    }

    /**
     * The function checks if Google Tag Manager (GTM) tracking is initialized by verifying the
     * presence of the dataLayer object and the start event, and optionally checking the unique event
     * ID if strict mode is enabled.
     * 
     * @param dataLayerName - The dataLayerName parameter is the name of the data layer object that is
     * used by Google Tag Manager (GTM) on the website. The data layer is a JavaScript object that
     * stores information that is used by GTM to track events and send data to various analytics and
     * marketing tools.
     * @param strict - The "strict" parameter is a boolean value that determines whether to perform an
     * additional check for the "gtm.uniqueEventId" property in the start event. If set to true, the
     * function will only return true if both the "gtm.start" and "gtm.uniqueEventId" properties
     * @returns a boolean value. It returns true if the GTM (Google Tag Manager) tracking is
     * initialized and ready to use, and false otherwise.
     */
    function isTrackingInitialized(dataLayerName, strict)
    {
        // without the datalayer GTM is not ready
        if(!window[dataLayerName]){
            return false;
        }
        // try to get the start event and if thats not
        // possible, GTM is not ready
        const startEvent = window[dataLayerName].find(element => element['gtm.start']);
        if(!startEvent){
            return false;
        }
        // if strict is true, we also check the unique id, which seems not to be
        // set by the magepal extension... Anyway, we let the check optional, so
        // we can use it if the behaviour changes or I missed something.
        if(strict === true && !startEvent['gtm.uniqueEventId']){
            return false;
        }
        // GTM is ready to use
        return true;
    }

    /**
     * The function `initTracking` initializes tracking using Google Tag Manager, either by detecting
     * if it was generated by an external party or by generating it internally.
     * 
     * @param dataLayerName - The name of the data layer object that is used to store and pass data to
     * Google Tag Manager.
     * @param accountId - The accountId parameter is the unique identifier for your Google Analytics
     * account. It is used to associate the tracking data with your account.
     * @param containerCode - The containerCode parameter is a string that represents the code or ID of
     * the Google Tag Manager container. This container is used to manage and deploy various tracking
     * tags and scripts on a website.
     * @param isExternal - A boolean value indicating whether the Google Tag Manager (GTM) is generated
     * by an external party or not. If it is true, the tracking will be initialized by waiting until
     * GTM is ready. If it is false, the tracking will be initialized by generating it internally.
     */
    function initTracking(dataLayerName, accountId, containerCode, isExternal)
    {
        $(document).trigger('gtm:beforeInitialize');
        // if true we also use the uniqueEventId of the start event
        // to detect if GTM is ready. Seems like the extension doesn´t
        // generate this id, our third party app does. But to keep
        // the compatibility to the self generated dataLayer event
        // we set it to false. However, it would be better if the
        // extension adds this id. Or -if this would be an option-
        //  in the administration panel.
        const strict = false;
        // we need to know, if we need to create the tracker by our self,
        // or if we need to detect if the tag manager was generated
        // by an external party (an external gdpr check for example)
        !!isExternal
            // initialize the tracking, by waiting until GTM is ready
            ? initTrackingExternal(dataLayerName, strict)
            // initialize the tracking the default way, by generating it
            : initTrackingInternal(dataLayerName, accountId, containerCode);
    }

    /**
     * Initialize the tracking by loading the GTM and setup
     * the dataLayer. 
     * 
     * @param {string} dataLayerName 
     * @param {string} accountId 
     * @param {any} containerCode 
     */
    function initTrackingInternal(dataLayerName, accountId, containerCode)
    {
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


    /**
     * The function `initTrackingExternal` checks if GTM (Google Tag Manager) is ready and fires the
     * "gtm:afterInitialize" event once it is.
     * 
     * @param dataLayerName - The dataLayerName parameter is the name of the data layer object that is
     * used for tracking in Google Tag Manager. It is typically set to "dataLayer" by default, but it
     * can be customized to a different name if needed.
     * @param strict - The "strict" parameter is a boolean value that determines whether the tracking
     * initialization check should be strict or not. If set to true, we also check the uniqueEventId
     * value, which should be defined in the start event
     */
    function initTrackingExternal(dataLayerName, strict)
    {
        // now we can just check if gtm is ready. An interval seems to be fair for
        // that check but if you find a better way, just change it ;)
        const checkInterval = setInterval(() => {
            // if GTM is ready we can clear  the interval
            // and fire the "gtm:afterInitialize" event
            if(isTrackingInitialized(dataLayerName, strict)){
                clearInterval(checkInterval);
                $(document).trigger('gtm:afterInitialize');
            }
        }, 100);
    }

    /**
     * The function "pushData" pushes data from an array into a specified data layer.
     * 
     * @param dataLayerName - The dataLayerName parameter is the name of the data layer object that you
     * want to push data into.
     * @param dataLayer - The `dataLayer` parameter is an array that contains data objects to be pushed
     * into the `dataLayerName` data layer.
     */
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

        if ((_.has(config, 'accountId') || !!config.isExternal) && isTrackingAllowed(config)) {
            pushData(config.dataLayer, config.data);
            initTracking(config.dataLayer, config.accountId, config.containerCode, config.isExternal);
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

});
