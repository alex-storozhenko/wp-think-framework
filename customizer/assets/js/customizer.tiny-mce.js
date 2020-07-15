(
    function ($) {
        'use strict';

        wp.customizerCtrlEditor = {

            init: function () {

                $(window).load(function () {

                    $('.wp-think-framework.customizer-input-area-tinyMCE .wp-editor-wrap').each(function () {
                        var tArea = $(this).find('textarea'),
                            id = tArea.attr('id'),
                            editor = tinyMCE.get(id),
                            setChange,
                            content;

                        if (editor) {
                            editor.on('change', function (e) {
                                e.preventDefault();
                                editor.save();
                                content = editor.getContent();
                                clearTimeout(setChange);
                                setChange = setTimeout(function () {
                                    tArea.val(content).trigger('change');
                                }, 500);
                            });
                        }

                        tArea.css({
                            visibility: 'visible'
                        }).on('keyup', function () {
                            content = tArea.val();
                            clearTimeout(setChange);
                            setChange = setTimeout(function () {
                                content.trigger('change');
                            }, 500);
                        });
                    });
                });
            }
        };

        wp.customizerCtrlEditor.init();
    }
)(jQuery);