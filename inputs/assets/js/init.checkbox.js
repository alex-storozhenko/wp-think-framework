(function ($) {
    'use strict';

    $('.wp-think-framework > .input-check').on('change', function () {
        var $self = $(this);
        $self.val(false);

        if (this.checked) {
            $self.val(true);
        }
    });
})(jQuery);