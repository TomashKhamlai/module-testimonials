define([
    'mage/storage',
    //'Magento_Ui/js/view/messages'
    ], function (storage) {
        'use strict';

        return function (url, requestData) {
            return storage.post(
                url, requestData, true, 'application/x-www-form-urlencoded'
            ).fail(
                function (response) {
                    let error;
                    try {
                        error = JSON.parse(response.responseText);
                    } catch (e) {
                        error = {
                            message: e.getText()
                        };
                    }
                    //messageContainer.addErrorMessage(error);
                }
            ).success(
                function (response) {
                    if (response.responseType !== 'error') {
                        console.log(response.data);
                    }
                }
            ).always(
                function () {
                    console.log('Time for a "stopProcess" event');
                }
            );
        }
    }
);
