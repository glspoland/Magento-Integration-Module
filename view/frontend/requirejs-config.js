var config = {
    paths: {
        'SzybkaPaczkaMap': [
            'https://mapa.szybkapaczka.pl/js/v3.1/maps_sdk'
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
