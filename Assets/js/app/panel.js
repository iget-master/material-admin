+function ($) {
	'use strict';

	// Panel menu toggler
	$('[role="menu-toggle"]').on('click', function() {
		$("#menu").toggleClass('open');
	});

	// User dropdown toggler
	$('[role="user-toggle"]').on('click', function() {
		$("#header .user-dropdown").toggleClass('open');
	});

	// Form submit button
	$('#content-toolbar').on('click', '[role="submit"]', function(e) {
		var form = $($(e.currentTarget).data('form'));
		form.submit();
	});


	/*
	 * Table related code
	 */

	// Table check all rows
	$('#content').on('click', 'table th input', function(e) {
		var $target = $(e.currentTarget);
		$target.closest('table').find('input[type="checkbox"]').prop('checked', $target.prop('checked'));
		$target.closest('table').trigger('selection-change');

	});

	// Table check row
	$('#content').on('click', 'table td input', function(e) {
		var $target = $(e.currentTarget);
		var $checkAll = $target.closest('table').find('th input[type="checkbox"]');

		// If check row is now checked, update check all rows.
		if ($target.prop('checked')) {
			var allChecked = true;
			$target.closest('tbody').find('td input[type="checkbox"]').each(function() {
				if ($(this).prop('checked') === false) {
					allChecked = false;
				}
			});
			$checkAll.prop('checked', allChecked);
		} else { // If not checked, then update check all rows to false.
			$checkAll.prop('checked', false);
		}

		$target.closest('table').trigger('selection-change');
		e.stopPropagation();
	});

	$('#content').on('selection-change', 'table', function(e) {
		var $target = $(e.currentTarget);
		if ($target.find('tbody').find('td input[type="checkbox"]:checked').length) {
			$("#content-toolbar").addClass('show-bulk');
		} else {
			$("#content-toolbar").removeClass('show-bulk');
		}
	})


	// Table row click shortcut
	$('#content').on('click', 'tbody tr', function(e) {
		var $edit = $(e.currentTarget).find('[role="edit"]');
		if ($edit.length) {
			var href = $(e.currentTarget).find('[role="edit"]').attr('href');
			location = href;
		}
	});

	$("#content table.index-table").on('selection-change', function(event) {
		if ($('#delete_items').length) {
			$('#delete_items input[name="id[]"]').remove();
			$("#content table.index-table tbody").find('input[type="checkbox"]:checked').each(function() {
				$("#delete_items").append('<input type="hidden" name="id[]" value="' + $(this).closest('tr').data('id') + '">');
			});
		}
	})
} (jQuery)