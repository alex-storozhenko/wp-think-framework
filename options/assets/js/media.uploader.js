;(function ($) {
    $(document).ready(function () {
        var $wrapper = $('.wrap');

        $wrapper.on("click", '.st_upload_button', function (e) {
            var self_button = e.target,
                $tr = $(self_button).closest('tr');

            var send_attachment_bkp = wp.media.editor.send.attachment;

            wp.media.editor.send.attachment = function (props, attachment) {

                var $img = $(self_button).parent().find("img");

                if (!$img.length) {
                    $img = $("<img class=\"image\" alt=\"Uploaded image\" style=\"width: 100%; height: auto\"/>");
                    $(self_button).parent().append($img);
                }

                $img.attr('src', attachment.url);
                $tr.find('.no_image_message').hide();
                $tr.find('.st_delete_upload_button').show();


                $(self_button).parent().parent().find("input").val(attachment.url);

                wp.media.editor.send.attachment = send_attachment_bkp;
            };

            wp.media.editor.open();

            return false;
        });

        $wrapper.on("click", '.st_delete_upload_button', function (e) {
            var self_button = e.target,
                $tr = $(self_button).parent();

            $tr.find('input').val('');
            $tr.find('.no_image_message').show();
            $tr.find('.image').remove();

            return false;
        });
    });
})(jQuery);