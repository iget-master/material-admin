'use strict';

+function ($) {
    'use strict';

    /*
     * Message related code
     */

    $('#messages-wrapper').on('click', '.message', function(e) {
        var $target = $(e.target);
        if (!$target.closest('.actions').length) {
            window.location = $target.closest('.message').attr('data-href');
            e.preventDefault();
        }
    });

} (jQuery)