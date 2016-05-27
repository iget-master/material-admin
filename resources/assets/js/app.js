+function ($) {
	'use strict';

	/* Toggler checkbox handler */
	$(document).on('click', 'input[type="checkbox"][role="toggle"]', function(event) {
		var $target = $(event.currentTarget);

		if (typeof $target.data('target') !== 'undefined') {
			if ($target.prop('checked')) {
				$($target.data('target')).removeClass('hide');
			} else {
				$($target.data('target')).addClass('hide');
			}
		}
	});

	/* Toogle Disbaled in Form Rows */
	$(document).on('click', 'input[type="checkbox"][role="enable"]', function(event) {
		var $target = $(event.currentTarget);

		if (typeof $target.data('target') !== 'undefined') {
			if ($target.prop('checked')) {
				$($target.data('target')).removeClass('disabled').find('input, select, textarea').removeAttr('disabled');
			} else {
				$($target.data('target')).addClass('disabled').find('input, select, textarea').attr('disabled', true);
			}
		}
	});

	/* Enable Save Button When Form is Edited*/
	$('form').on('input change', function() {
		$('#save').removeAttr('disabled');
	});

    /* Enable Save Button When Form is Edited*/
    $('.save-button,.enable-save').on('click', function() {
        $('#save').removeAttr('disabled');
    });

	/* Enable Save Button When relational Table is Updated */
	$('.relational').on('updated', function() {
		$('#save').removeAttr('disabled');
	});

	/* Initialize Tooltips */
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            delay: {show: 1000, hide: 200}
        });
    });

    $('#drawer-wrapper .menu').css({'overflow': 'auto'});

    function updateMenuHeight() {
        var $header = $('#drawer-wrapper .header');
        var $menu = $('#drawer-wrapper .menu');
        var height = $(window).height();

        $menu.css({'max-height': height - $header.outerHeight()});
    }

    $(window).on('resize', updateMenuHeight);

	// Document ready event handler
    $(function () {
        updateMenuHeight();
		// Instantiates the file uploader method
		$('#file').fileuploader();
    });

    // Configure jQuery Ajax to always send CSRF Token as request header.
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

} (jQuery);
