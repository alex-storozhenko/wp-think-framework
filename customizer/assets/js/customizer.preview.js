/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */
(function ($) {
    'use strict';

    var api = wp.customize;
    var elements = thinkCustomizer.structure;

    $(elements).each(function (i, section) {
        $(section.controls).each(function (i, control) {
            if (typeof control.selector === 'undefined' || !control.selector.length) {
                control.selector = '#' + control.id;
            }

            api(control.id, function (value) {
                value.bind(function (to) {
                    switch (control.type) {
                        case 'image':
                        case 'cropped_image':
                            $(control.selector).html('<img class="' + control.id + '" src="' + to + '" alt="' + control.id + '"/>');
                            break;
                        case 'color':
                            $(control.selector).css('color', to);
                            break;
                        case 'background_color':
                            $(control.selector).css('background-color', to);
                            break;

                        default:
                            $(control.selector).text(to);
                            break;
                    }
                })
            })
        })
    });
})(jQuery);