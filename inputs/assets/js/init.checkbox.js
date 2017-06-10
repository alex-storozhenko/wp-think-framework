(function ($) {
    'use strict';

    $('.wp-think-framework > .input-check').on('change', function () {
        var $_self = $(this);
        $_self.val(false);

        if (this.checked) {
            $_self.val(true);
        }
    });
})(jQuery);