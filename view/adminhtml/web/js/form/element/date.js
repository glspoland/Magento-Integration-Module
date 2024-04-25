define([
    'Magento_Ui/js/form/element/date'
], function(Magento_Ui_Date) {
    'use strict';

    return Magento_Ui_Date.extend({
        defaults: {
            options: {
                beforeShowDay: function (Magento_Ui_Date) {
                    const day = Magento_Ui_Date.getDay();
                    const dayNumber = Magento_Ui_Date.getDate();
                    const today = new Date().getDate();

                    return [
                        (day !== 0 && day !== 6 && dayNumber !== today),
                        ''
                    ];
                }
            }
        }
    });
});
