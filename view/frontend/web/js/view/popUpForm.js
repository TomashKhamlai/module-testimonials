define([
    'Magento_Ui/js/form/form',
    'jquery',
    'ko',
    'Magento_Ui/js/modal/modal',
    'Overdose_Testimonials/js/action/submit'
], function (
    Component,
    $,
    ko,
    modal,
    submitAction
) {
    'use strict';

    let popUp = null;

    return Component.extend({
        defaults: {
            template: 'Overdose_Testimonials/popup',
            formTemplate: 'Overdose_Testimonials/form',
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

        submitTestimonial: function (event) {
            let self = this,
                formData = self.source.get('testimonialComponentScope');

            console.log('Time for a "startProcess" event');
            submitAction(formData)
                .fail(
                    function (response) {
                        let error;
                        try {
                            error = JSON.parse(response.responseText);
                        } catch (e) {
                            error = {
                                message: e.getText()
                            };
                        }
                    }
                ).success(
                function (response) {
                    if (response.responseType !== 'error') {
                        console.log(response);
                    }
                }
            ).always(
                function () {
                    console.log('Time for a "stopProcess" event');
                    self.onClosePopUp();
                }
            );
        },

        onClosePopUp: function () {
            this.constructPopUp().closeModal();
        },

        constructPopUp: function () {
            let self = this,
                buttons;

            if (!popUp) {
                buttons = this.popUpForm.options.buttons;
                this.popUpForm.options.buttons = [{
                    text: buttons.save.text ? buttons.save.text : $t('Publish'),
                    class: buttons.save.class ? buttons.save.class : 'action primary action-publish-testimonial',
                    click: self.submitTestimonial.bind(self)
                }, {
                    text: buttons.cancel.text ? buttons.cancel.text : $t('Cancel'),
                    class: buttons.cancel.class ? buttons.cancel.class : 'action secondary action-hide-popup',
                    click: self.onClosePopUp.bind(self)
                }];

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
