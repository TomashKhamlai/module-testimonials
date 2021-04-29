define([
    'Magento_Ui/js/form/element/file-uploader',
    'ko',
    'underscore',
    'jquery'
], function (Element, ko, _, $) {
    'use strict';

    return Element.extend({
        defaults: {
            dropZoneSelector: '.file-uploader.colored',
            cx: '50%',
            cy: '50%',
            rect : ko.observable()
        },

        initialize: function () {
            self = this;
            this._super();
            //this.updateRect()
            $(this.dropZoneSelector).resize(
                function () {
                    this.updateRect();
                }
            );
            this.generateStyleString = ko.computed(function() {
                return self.dropZoneSelector +
                    '::before {' +
                    'content:"";position:absolute;top:0;left:0;z-index:-1;display:block;width:100%;height:100%;' +
                    'background-image' +
                    ': ' +
                    'radial-gradient(circle at ' + self.cx() + ' ' + self.cy() + ', transparent 30%, #6cc8ff 256px 256px)' +
                    '!important;}';
            }, this);
        },

        updateRect: function () {
            this.rect = $(this.dropZoneSelector)[0].getBoundingClientRect();
            return this;
        },

        /**
         * Initialize observables.
         *
         * @returns {Object} Chainable.
         */
        initObservable: function () {
            this
                ._super()
                .observe(['processedFile', 'cx', 'cy', 'rect']);
            return this;
        },

        clearCoords: function () {
            this.cx('50%');
            this.cy('50%');
            this.updateRect();
            return this;
        },

        sayHello: function (data, event) {
            let lcx = event.offsetX;
            let lcy = event.offsetY;
            console.log('Click at  x=', lcx, ' y=', lcy);
        },

        updateCoords: function (data, event) {
            console.log(event.clientX , ' - ', this.rect.left, ' ', event.clientX, ' - ', this.rect.left);
            this.cx(event.clientX - this.rect.left + 'px');
            this.cy(event.clientY - this.rect.top + 'px');

            return this;
        },

        /**
         * Delete Image
         *
         * @returns {Object} Chainable
         */
        deleteImage: function () {
            this.processedFile({});
            this.value(null);
            return this;
        }
    });
});
