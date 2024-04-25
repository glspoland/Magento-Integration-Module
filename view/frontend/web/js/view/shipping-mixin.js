define([
    'jquery',
    'ko',
    'Magento_Checkout/js/model/quote',
    'mage/translate',
    'Magento_Customer/js/customer-data'
], (
    $,
    ko,
    quote,
    $t,
    customerData
) => {
    const mixin = {
        errorValidationMessage: ko.observable(false),

        selectShippingMethod: function () {
            this._super();

            var checkedRadio = $('.table-checkout-shipping-method input[type=radio]:checked');
            var activeRow = $('.table-checkout-shipping-method .row.active');

            if (activeRow.length > 0) {
                activeRow.removeClass('active');
            }

            if (checkedRadio.length > 0) {
                checkedRadio.closest('.row').addClass('active')
            }

            return true;
        },

        validateShippingInformation: function() {
            var self = this;

            if(quote.shippingMethod()) {
                var shippingCode = quote.shippingMethod().method_code+'_'+quote.shippingMethod().carrier_code;
                var validShippingCodes = ['gls_parcel_shop_glspoland'];
                
                if (validShippingCodes.includes(shippingCode) && !self.getGlsParcelPoint()) {
                    self.errorValidationMessage($t('Please select a parcel point'));
                    return false;
                }
            }

            return this._super();
        },

        getGlsParcelPoint: function() {
            var glsParcelPoint = customerData.get('glsParcel')['shop_id'];
            return glsParcelPoint !== undefined;
        }
    };

    return function (target) {
        return target.extend(mixin);
    };
});
