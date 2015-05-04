'use strict';

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
				$($target.data('target')).removeClass('disabled');
			} else {
				$($target.data('target')).addClass('disabled');
			}
		}
	});


	/* Enable Save Button When Form is Edited*/
	$('form').on('input change', function() {
		$('#save').removeAttr('disabled');
	});

	/* Enable Save Button When relational Table is Updated */
	$('.relational').on('updated', function() {
		$('#save').removeAttr('disabled');
	});

} (jQuery)