define([
    'Magento_Ui/js/form/form',
    'jquery',
    'ko',
    'Magento_Ui/js/modal/modal',
    'uiRegistry'
], function (
    Component,
    $,
    ko,
    modal,
    registry
) {
    'use strict';

    let popUp = null;

    return Component.extend({
        defaults: {
            template: 'Overdose_Testimonials/popup-form',
            isFormPopUpVisible: ko.observable(false)
        },

        initialize: function () {
            let self = this;

            this._super();

            this.isFormPopUpVisible.subscribe(function (value) {
                if (value) {
                    self.constructPopUp().openModal();
                }
            });

            return this;
        },

        onClosePopUp: function () {
            this.constructPopUp().closeModal();
        },

        constructPopUp: function () {
            let self = this,
                buttons;

            if(!popUp) {
                buttons = this.popUpForm.options.buttons;
                this.popUpForm.options.buttons = [
                    {
                        text: buttons.save.text ? buttons.save.text : $t('Publish'),
                        class: buttons.save.class ? buttons.save.class : 'action primary action-publish-testimonial'
                    },
                    {
                        text: buttons.cancel.text ? buttons.cancel.text : $t('Cancel'),
                        class: buttons.cancel.class ? buttons.cancel.class : 'action secondary action-hide-popup',
                        click: this.onClosePopUp.bind(this)
                    }
                ];

                this.popUpForm.options.closed = function () {
                    self.isFormPopUpVisible(false);
                };

                popUp = modal(this.popUpForm.options, $(this.popUpForm.element));
            }

            return popUp;
        },

        showFormPopUp: function () {
            this.isFormPopUpVisible(true);
        }
    });
});
