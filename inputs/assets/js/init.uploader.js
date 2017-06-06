(function ($) {
    'use strict';

    var $wrapper = $('.wp-think-framework.input-area-image');

    $(document).ready(function () {
        var toggle_func = function (htmlElement) {
            if (htmlElement.hasClass('hidden')) {
                htmlElement.removeClass('hidden');
                htmlElement.addClass('visible');
            } else {
                htmlElement.removeClass('visible');
                htmlElement.addClass('hidden');
            }
        };

        $wrapper.on('click', '.button-group > .call-media', function (e) {
            e.preventDefault();

            var $wrapper = $(this).parent('.button-group').parent('.wp-think-framework.input-area-image');
            var $preview_popup = $wrapper.find('.wp-think-framework.popup-overlay');
            var $preview_button = $wrapper.find('.button-group > .preview-image');
            var $preview_img = $preview_popup.children().children('img');
            var $url_input = $wrapper.find('.input-text');
            var send_attachment_bkp = wp.media.editor.send.attachment;

            wp.media.editor.send.attachment = function (props, attachment) {
                $preview_button.removeAttr('disabled', 'disabled');
                $preview_img.attr('src', attachment.url);
                $url_input.val(attachment.url);

                if (!$preview_popup.hasClass('visible')) {
                    toggle_func($preview_popup);
                }

                wp.media.editor.send.attachment = send_attachment_bkp;
            };

            wp.media.editor.open();
        });

        $wrapper.on('click', '.button-group > .remove-image', function (e) {
            e.preventDefault();

            var $wrapper = $(this).parent('.button-group').parent('.wp-think-framework.input-area-image');
            var $preview_popup = $wrapper.find('.wp-think-framework.popup-overlay');
            var $preview_button = $wrapper.find('.button-group > .preview-image');
            var $preview_img = $preview_popup.children().children('img');
            var $url_input = $wrapper.find('.input-text');

            if (!$preview_popup.hasClass('hidden')) {
                toggle_func($preview_popup);
            }

            $preview_button.attr('disabled', 'disabled');
            $preview_img.attr('src', 'javascript:;');
            $url_input.val('');
        });

        $wrapper.on('click', '.button-group > .preview-image', function (e) {
            e.preventDefault();

            var $wrapper = $(this).parent('.button-group').parent('.wp-think-framework.input-area-image');
            var $preview_popup = $wrapper.find('.wp-think-framework.popup-overlay');

            toggle_func($preview_popup);
        });

        $wrapper.on('click', '.popup-preview-image > .close', function (e) {
            e.preventDefault();

            var $preview_popup = $(this).closest('.wp-think-framework.popup-overlay');

            toggle_func($preview_popup);
        });
    });
})(jQuery);