define([
    'Overdose_Testimonials/js/model/testimonial'
], function (model) {
    'use strict';

    return function (data) {
        const url = 'testimonials/form/post';
        return model(url, new URLSearchParams(data).toString());
    }
});
