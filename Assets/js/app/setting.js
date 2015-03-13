+function ($) {
	'use strict';

	// Bind edit and delete actions for each Setting Item <li>
	$('#settings-groups').on('click', '.editable a, li.editable', function(e) {
		var $target = $(e.currentTarget);

		console.log($target);

		if ($target.hasClass('edit') || $target.hasClass('editable')) {
			new ModalForm($target.closest('li').data('edit'));
			//window.location.href = $target.closest('li').data('edit');
		} else if ($target.hasClass('delete')) {
			new ModalForm($target.closest('li').data('delete'));
			//window.location.href = $target.closest('li').data('delete');
		}
		e.stopPropagation();
	});

	// Bind create action for each Setting Item
	$('#settings-groups').on('click', '.settings-item a.create', function(e) {
		window.location.href = $(e.currentTarget).closest('.settings-item').data('create')
	})
} (jQuery)