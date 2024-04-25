var config = {
    map: {
        '*': {
            glsPointsMapGeneratorAdminPanel: 'GlsPoland_Shipping/js/gls-points-map-generator-admin-panel'
        }
    },
    paths: {
        'SzybkaPaczkaMap': [
            'https://mapa.szybkapaczka.pl/js/v3.1/maps_sdk'
        ],
    },
    config: {
        mixins: {
            'mage/validation': {
                'GlsPoland_Shipping/js/validation-mixin': true
            }
        }
    },
    shim: {
        'glsPointsMapGeneratorAdminPanel': ['jquery', 'SzybkaPaczkaMap'],
    }
}