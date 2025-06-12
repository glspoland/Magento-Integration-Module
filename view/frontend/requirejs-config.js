var config = {
    paths: {
        'SzybkaPaczkaMap': [
            'https://mapa.gls-poland.com/js/v4.0/maps_sdk'
        ],
    },
    config: {
        mixins: {
            'Magento_Checkout/js/view/shipping': {
                'GlsPoland_Shipping/js/view/shipping-mixin': true
            },
        }
    }
};
