define([
    'ko',
    'uiComponent',
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-service',
    'mage/translate',
    'Magento_Ui/js/modal/modal',
    'Magento_Customer/js/customer-data',
    'mage/url',
    'SzybkaPaczkaMap',
    'domReady!'
], function (ko, Component, $, quote, shippingService, $t, modal, customerData, url) {
    
    'use strict';
    return Component.extend({
        defaults: {
            template: 'GlsPoland_Shipping/gls-popup-with-map',
            methodCodeParcel: 'gls_parcel_shop',
            labelParcel : 'label_method_gls_parcel_shop_glspoland',
            mapModalId: '#gls-shipping-modal',
            mapElement: 'gls-shipping-map',
            polishLang: 'pl',
            englishLang: 'en',
            defaultCountryId: 'PL',
            countryId: ko.observable(''),
            defaultParcelWeight: 1,
            geolocation: false,
            mapType: false,
            mapInitialization: ko.observable(false),
            mapModalClass: 'gls-map-modal',
            selectedParcelButtonId: '#selected_parcel',
            glsPointCity: '.gls-point-address .city',
            glsPointStreet: '.gls-point-address .street',
            glsPointPostalCode: '.gls-point-address .postal-code',
            glsChosenPointAddress: ko.observable({}),
            firstRun: ko.observable(true),
            glsImageWrapperClass: 'gls-image-wrapper',
            glsDataClassCss: '.gls-data'
        },

        initialize: function () {
            var self = this;

            var availableShippingMethods = [];

            shippingService.getShippingRates().subscribe(function (rates) {
                availableShippingMethods = rates;
            });


            shippingService.isLoading.subscribe(function (isLoading) {
                if (!isLoading) {
                    var parcel = self.isParcelAvailable(availableShippingMethods);

                    if (availableShippingMethods.length > 0 && parcel) {
                        var code = parcel.method_code + '_' + parcel.carrier_code;
                        self.initShippingGls('#label_method_' + code);
                    }

                    self.checkSelectedRadioAfterRender();
                }
            });

            this.showPopupWithMap();

            quote.shippingMethod.subscribe(function () {
                var parcel = self.isParcelAvailable(availableShippingMethods);

                if (
                    quote.shippingAddress() !== null &&
                    quote.shippingAddress().countryId !== self.countryId() &&
                    self.countryId() !== ''
                ) {
                    self.destroyMap();
                    self.initializeMap();
                    self.glsChosenPointAddress({});
                    self.clearParcelIdInQuote();
                }
                

                if ($(self.glsDataClassCss).length === 0 && parcel) {
                    var code = parcel.method_code + '_' + parcel.carrier_code;
                    self.initShippingGls('#label_method_' + code);
                }

                self.checkSelectedRadioAfterRender();
            });

            this._super();
        },

        isParcelAvailable: function(rates) {
            var self = this;
            
            return rates.find((element) => element.method_code == self.methodCodeParcel);
        },

        initShippingGls: function(selector) {
            this.renderShippingMethod(selector);
        },

        elementReady: function(selector) {
            return new Promise((resolve, reject) => {
                var observer = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        if (document.querySelectorAll(selector).length > 0) {
                            resolve(document.querySelector(selector));
                            this.initMapModal();
                            observer.disconnect();
                        }
                    });
                });

                observer.observe(document.documentElement, { childList: true, subtree: true });
            });
        },

        renderShippingMethod: function(selector) {
            var self = this;
            return new Promise(function(resolve) {
                self.elementReady(selector).then(() => {
                    if ($(selector).length > 0) {

                        if ($(self.glsDataClassCss).length > 0) {
                            resolve(true);
                            return;
                        }

                        if (selector.indexOf(self.labelParcel) > -1 ) {
                            self.renderButton(selector, $t('Choose point'));
                        }

                        if (self.firstRun()) {
                            self.checkSelectedRadioAfterRender();
                            self.firstRun(false)
                        }

                        resolve(true);
                        return;
                    } else {
                        resolve(false);
                    }

                    if (self.glsChosenPointAddress().city && $(self.glsPointCity).text() === '') {
                        self.fillAddressData(self.glsChosenPointAddress().city, self.glsChosenPointAddress().postal_code, self.glsChosenPointAddress().street)
                    }
                });
            });
        },

        checkSelectedRadioAfterRender: function() {
            var checkedRadio = $('.table-checkout-shipping-method input[type=radio]:checked');

            if (checkedRadio.length) {
                checkedRadio.closest('.row').addClass('active');
            }

            if ($('#'+this.labelParcel).find(this.glsDataClassCss).length === 0) {
                this.renderButton('#'+this.labelParcel, $t('Choose point'));
            }

            if (this.glsChosenPointAddress().city && $(this.glsPointCity).text() === '') {
                this.fillAddressData(this.glsChosenPointAddress().city, this.glsChosenPointAddress().postal_code, this.glsChosenPointAddress().street)
            }
        },

        renderButton: function(selector, textButton) {
            var wrapper = $(selector);
            var html = '<div class="gls-data">';
                html += '<div class="gls-point-address">';
                html += '<p class="city"></p>';
                html += '<p class="street"></p>';
                html += '<p class="postal-code"></p>';
                html += '</div>';
                html +=  '<button class="action choose-point">'+ textButton +'</button>';
                html += '</div>';

            if (wrapper.length > 0) {
                wrapper.append(html);
            }
        },

        initMapModal: function() {
            if (document.querySelector('.' + this.mapModalClass) !== null) {
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

        fillAddressData: function(city, postal_code, street) {
            city && $(this.glsPointCity).text(city);
            postal_code && $(this.glsPointPostalCode).text(postal_code);
            street && $(this.glsPointStreet).text(street);
        },

        showPopupWithMap: function() {
            var self = this;
            $(document).on('click', '.action.choose-point', function(e) {
                e.preventDefault();
                $(self.mapModalId).modal('openModal');
            });
        },

        initializeMap: function () {
            var self = this;
            var countryId = this.defaultCountryId;
            var languageMap = this.polishLang;
            var parcelWeight = this.getTotalWeight() ? this.getTotalWeight() : this.defaultParcelWeight;

            if (quote.shippingAddress() !== null && quote.shippingAddress().countryId) {
                var countryIdFromQuote = quote.shippingAddress().countryId;
                this.countryId(countryIdFromQuote);
                countryId = countryIdFromQuote;
                languageMap = countryIdFromQuote !== this.defaultCountryId ? this.englishLang : this.polishLang;
            }

            SzybkaPaczkaMap.init({
                lang: languageMap.toLowerCase(),
                country_parcelshops: countryId.toLowerCase(),
                el: this.mapElement,
                geolocation: this.geolocation,
                map_type: this.mapType,
                parcel_weight: parcelWeight
            });
    
            window.addEventListener('get_parcel_shop', function (event) {
                if (event.target.ParcelShop.selected) {
                    var { city, id, postal_code, street } = event.target.ParcelShop.selected;
                    $(self.mapModalId).modal('closeModal');
                    self.fillAddressData(city, street, postal_code);
                    self.updateParcelShopId(id);
                    self.glsChosenPointAddress({city, street, postal_code});
                }
            });

            this.mapInitialization(true);
        },

        updateParcelShopId: function(parcelShopId) {
            if(!parcelShopId) {
                return;
            }

            var glsParcel = customerData.get('glsParcel');
            glsParcel.shop_id = parcelShopId;
            customerData.set('glsParcel', glsParcel);

            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: "POST",
                    url: url.build('/gls_poland/parcelshop/save'),
                    data: {
                        'gls_poland_parcel_shop_id': parcelShopId,
                        'scope': 'frontend'
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
        
        destroyMap: function() {
            $('#'+this.mapElement).empty();
        },

        clearParcelIdInQuote: function() {
            var glsParcel = customerData.get('glsParcel');
            glsParcel.shop_id = undefined;
            customerData.set('glsParcel', glsParcel);
        },

        getTotalWeight: function() {
            var items = quote.getItems();
            var totalSum = 0;

            items.forEach(function(item) {
                totalSum += item.product.weight * item.qty;
            });

            return totalSum;
        },
    });
});