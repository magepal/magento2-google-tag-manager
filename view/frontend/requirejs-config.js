var config = {
    map: {
        '*': {
            magepalGtmDatalayer: 'MagePal_GoogleTagManager/js/datalayer'
        }
    },
    shim: {
        'MagePal_GoogleTagManager/js/datalayer': ['Magento_Customer/js/customer-data']
    }
};
