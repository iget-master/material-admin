+function ($) {
	'use strict';

	// Bind edit and delete actions for each Setting Item <li>
	$('#settings-groups').on('click', '.editable a, li.editable, tr.editable', function(e) {
		var $target = $(e.currentTarget);

		if ($target.hasClass('edit') || $target.hasClass('editable')) {
			window.location.href = $target.closest('.editable').data('edit');
		} else if ($target.hasClass('delete')) {
			window.location.href = $target.closest('.editable').data('delete');
		}
		e.stopPropagation();
	});

	// Bind create action for each Setting Item
	$('#settings-groups').on('click', '.settings-item a.create', function(e) {
		window.location.href = $(e.currentTarget).closest('.settings-item').data('create')
	})

	// Bind show action for each Setting Item
	$('#settings-groups').on('click', '.settings-item a.show', function(e) {
		window.location.href = $(e.currentTarget).closest('.settings-item').data('show')
	})
} (jQuery)