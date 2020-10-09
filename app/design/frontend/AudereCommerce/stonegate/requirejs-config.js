var config = {
    map: {
        'header': 'js/header',
        'dropdown': 'js/dropdown',
        'Magento_Checkout/template/minicart/content.html': 'Vendor_ModuleName/template/minicart/content.html'
    },
    shim: {
        'header': {
            deps: ['jquery']
        },
        'dropdown': {
            deps: ['jquery']
        },
        'footer': {
            deps: ['jquery']
        }
    }
};