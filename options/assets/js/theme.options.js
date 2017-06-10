(function ($) {
    'use strict';

    $(document).ready(function () {
        $('section.tab_content').not(':eq(0)').hide();
        $('section.tab_content:eq(0)').show();

        $('.nav-tab-wrapper').on('click', '.nav-tab', function (e) {
            $('.nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');

            var id = $(this).data('tab');

            $('section.tab_content').hide();
            $('section.tab_content#' + id).show();
        });
    });
})(jQuery);