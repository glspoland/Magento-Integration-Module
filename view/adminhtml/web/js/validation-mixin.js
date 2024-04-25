define(['jquery'], function($) {
    'use strict';

    return function(target) {
        $.validator.addMethod(
            'validate-min-max-float',
            function(value, element) {
                return parseFloat(value) >= 0.1;
            },
            $.mage.__('The minimum possible value is 0.1.')
        );

        $.validator.addMethod(
            'validate-number-not-zero',
            function(value, element) {
                return value >= 1;
            },
            $.mage.__('The minimum possible value is 1.')
        );

        return target;
    }
});