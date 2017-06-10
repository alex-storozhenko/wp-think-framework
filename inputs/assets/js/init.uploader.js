(function ($) {
    'use strict';

    var $wrapper = $('.wp-think-framework.input-area-image');

    $(document).ready(function () {
        var togglebyClass = function (htmlElement) {
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

            var $localWrapper = $(this).parent('.button-group').parent('.wp-think-framework.input-area-image');
            var $previewPopup = $localWrapper.find('.wp-think-framework.popup-overlay');
            var $previewButton = $localWrapper.find('.button-group > .preview-image');
            var $previewImg = $preview_popup.children().children('img');
            var $urlInput = $localWrapper.find('.input-text');
            var sendAttachmentBkp = wp.media.editor.send.attachment;

            wp.media.editor.send.attachment = function (props, attachment) {
                $previewButton.removeAttr('disabled', 'disabled');
                $previewImg.attr('src', attachment.url);
                $urlInput.val(attachment.url);

                if (!$previewPopup.hasClass('visible')) {
                    togglebyClass($previewPopup);
                }

                wp.media.editor.send.attachment = sendAttachmentBkp;
            };

            wp.media.editor.open();
        });

        $wrapper.on('click', '.button-group > .remove-image', function (e) {
            e.preventDefault();

            var $localWrapper = $(this).parent('.button-group').parent('.wp-think-framework.input-area-image');
            var $previewPopup = $localWrapper.find('.wp-think-framework.popup-overlay');
            var $previewButton = $localWrapper.find('.button-group > .preview-image');
            var $urlInput = $localWrapper.find('.input-text');
            var $previewImg = $previewPopup.children().children('img');

            if (!$previewPopup.hasClass('hidden')) {
                togglebyClass($previewPopup);
            }

            $previewButton.attr('disabled', 'disabled');
            $previewImg.attr('src', 'javascript:;');
            $urlInput.val('');
        });

        $wrapper.on('click', '.button-group > .preview-image', function (e) {
            e.preventDefault();

            var $localWrapper = $(this).parent('.button-group').parent('.wp-think-framework.input-area-image');
            var $previewPopup = $localWrapper.find('.wp-think-framework.popup-overlay');

            togglebyClass($previewPopup);
        });

        $wrapper.on('click', '.popup-preview-image > .close', function (e) {
            e.preventDefault();

            var $previewPopup = $(this).closest('.wp-think-framework.popup-overlay');

            togglebyClass($previewPopup);
        });
    });
})(jQuery);