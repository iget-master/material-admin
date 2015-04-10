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

	/* Enable Save Button */

	$('form').on('input', function() {
		$('#save').removeAttr('disabled');
	});

} (jQuery)