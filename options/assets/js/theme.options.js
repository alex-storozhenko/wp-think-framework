;(function ($) {
    $(document).ready(function () {
        $('section.tab_content').not(':eq(0)').hide();
        $('section.tab_content:eq(0)').show();

        $('.nav-tab-wrapper').on('click', '.nav-tab', function (e) {
            e.preventDefault();

            $('.nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');

            var id = $(this).data('tab');

            $('section.tab_content').hide();
            $('section.tab_content#' + id).show();
        });

        $('.theme_colorpicker').wpColorPicker();
    });
})(jQuery);