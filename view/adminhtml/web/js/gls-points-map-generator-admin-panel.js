define([
    'ko',
    'uiComponent',
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/translate',
    'mage/url',
    'SzybkaPaczkaMap'
], function (ko, Component, $, modal, $t, url) {
    'use strict';

    return Component.extend({
        defaults: {
            idParcel: '#s_method_glspoland_gls_parcel_shop',
            methodCodeParcel: 'glspoland_gls_parcel_shop',
            mapModalClass: 'gls-map-modal',
            mapModalId: '#gls-shipping-modal',
            mapElement: 'gls-shipping-map',
            defaultParcelWeight: 1,
            geolocation: false,
            mapType: false,
            defaultCountryId: 'PL',
            polishLang: 'pl',
            englishLang: 'en',
            mapInitialization: ko.observable(false),
            glsChosenPointAddress: ko.observable({}),
            glsPointCity: '.gls-point-address .city',
            glsPointStreet: '.gls-point-address .street',
            glsPointPostalCode: '.gls-point-address .postal-code',
            glsParcelPointDatalocalStorageKey: 'glsParcel',
            shipmentRadioButtons: '#order-shipping-method-choose .admin__control-radio',
            glsInputValidateSelector: '#gls_parcel_validate',
            countryInputSelector: '#order-billing_address_country_id',
            getShippingMethodsButtonSelector: '#order-shipping-method-summary .action-default',
            choosePointSelector: '.action.choose-point',
            countryId: ko.observable(''),
            parcelWeight: ko.observable('')
        },

        initialize: function () {
            this._super();
            
            if (this.checkParcelDeliveryMethodExists()) {
                this.initMapModal();
                this.showPopupWithMap();
                this.addEventClear();
                this.addEventChoosePoint();
                this.checkWeightHandler();
            }

            this.detectChangeCountry();
        },

        initMapModal: function() {
            if ($('.' + this.mapModalClass).length > 0) {
                return;
            }
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: $t('Choose the collection point'),
                clickableOverlay: true,
                modalClass: this.mapModalClass,
                buttons: false
            };
            
            modal(options, $(this.mapModalId));

            if (!this.mapInitialization()) {
                this.initializeMap();
            }
        },

        checkParcelDeliveryMethodExists: function() {
            return ($(this.idParcel) !== null);
        },

        showPopupWithMap: function() {
            var self = this;
            
            $(document).on('click', this.choosePointSelector, function(e) {
                e.preventDefault();
                $(self.mapModalId).modal('openModal');
            });
        },

        checkWeightHandler: function() {
            var self = this;
            $(document).on('click', this.getShippingMethodsButtonSelector, function(e) {
                e.preventDefault();

                if (self.parcelWeight() !== self.getWeight()) {
                    self.destroyMap();
                    self.initializeMap();
                    self.removeParcelDataLocalStorage();
                }
            });
        },

        initializeMap: function () {
            var countryId = this.defaultCountryId;
            var languageMap = this.polishLang;
            var selectCountry = $(this.countryInputSelector).val();
            var parcelWeight = this.getWeight() || this.defaultParcelWeight;
            this.countryId(selectCountry);
            this.parcelWeight(parcelWeight);
            
            if (selectCountry !== this.defaultCountryId) {
                countryId = selectCountry;
                languageMap = selectCountry !== this.defaultCountryId ? this.englishLang : this.polishLang;
            }

            SzybkaPaczkaMap.init({
                lang: languageMap.toLowerCase(),
                country_parcelshops: countryId.toLowerCase(),
                el: this.mapElement,
                geolocation: this.geolocation,
                map_type: this.mapType,
                parcel_weight: parcelWeight
            });
    
            this.mapInitialization(true);
        },

        fillAddressData: function(city, postal_code, street) {
            city && $(this.glsPointCity).text(city);
            postal_code && $(this.glsPointPostalCode).text(postal_code);
            street && $(this.glsPointStreet).text(street);
        },

        updateParcelShopId: function(parcelShopId, city, street, postal_code) {
            if (!parcelShopId) {
                return;
            }

            var glsParcelData = {
                parcelShopId,
                city,
                street,
                postal_code
            };

            this.fillAddressData(city, postal_code, street);
            this.fillInputValidate(parcelShopId);
            localStorage.setItem(this.glsParcelPointDatalocalStorageKey, JSON.stringify(glsParcelData));

            return new Promise(function(resolve, reject) {
                var orderConfigData = $('#edit_form').attr('data-order-config');
                var orderConfig = JSON.parse(orderConfigData);
                var quoteId = orderConfig.quote_id ? orderConfig.quote_id : null;

                $.ajax({
                    type: "POST",
                    url: url.build('/gls_poland/parcelshop/save'),
                    data: {
                        'gls_poland_parcel_shop_id': parcelShopId,
                        'scope': 'backend',
                        'quote_id': quoteId
                    },
                    dataType: 'json'
                }).done(function(data) {
                    if (data.status === 1) {
                        resolve('true');
                    } else {
                        reject('false');
                    }
                });
            });
        },

        detectChangeCountry: function() {
            var self= this;

            $(this.countryInputSelector).on('change', function(event){
                self.destroyMap();
                self.initializeMap();
                self.removeParcelDataLocalStorage();
            })
        },

        fillDataOnInitiate: function (pointData) {
            this.fillAddressData(pointData.city, pointData.postal_code, pointData.street);
        },
        
        fillInputValidate: function (id) {
            if (id !== null) {
                $(this.glsInputValidateSelector).val(id);
            }
        },

        addEventChoosePoint: function() {
            var self =this;

            window.addEventListener('get_parcel_shop', function (event) {
                var point = event.target

                if (point.ParcelShop.selected) {
                    var { city, id, postal_code, street } = point.ParcelShop.selected;
                    $(self.mapModalId).modal('closeModal');
                    self.fillAddressData(city, street, postal_code);
                    self.updateParcelShopId(id, city, street, postal_code);
                    self.glsChosenPointAddress({city, street, postal_code});
                }
            });
        },

        addEventClear: function() {
            var self = this;

            $(document).on('click', this.shipmentRadioButtons, function(event) {
                var selectedMethodCode = event.target.value;
                if (selectedMethodCode !== self.methodCodeParcel) {
                    self.removeParcelDataLocalStorage();
                }
            });
        },

        destroyMap: function() {
            $('#'+this.mapElement).empty();
        },

        removeParcelDataLocalStorage: function() {
            localStorage.removeItem(this.glsParcelPointDatalocalStorageKey);
        }, 

        getWeight: function() {
            return $(this.glsInputValidateSelector).attr('data-weight');
        }
    });
});