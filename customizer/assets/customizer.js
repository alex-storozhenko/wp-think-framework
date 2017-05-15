/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */
(function ($) {
    var elements = {};

    $(Object.keys(elements)).each(function (ind, key) {

        wp.customize(key, function (value) {
            value.bind(function (newval) {

                switch (key) {
                    case 'image':
                        $(elements[key]).html('<img src="' + newval + '" alt="image" />');
                        break;
                    default:
                        $(elements[key]).html(newval);
                        break;
                }
            });
        });
    });
})(jQuery);