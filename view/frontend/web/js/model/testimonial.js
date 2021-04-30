define([
    'mage/storage',
    //'Magento_Ui/js/view/messages'
    ], function (storage) {
        'use strict';

        return function (url, requestData) {
            return storage.post(url, requestData, true, 'application/x-www-form-urlencoded')
        }
    }
);
