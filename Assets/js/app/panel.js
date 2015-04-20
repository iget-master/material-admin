'use strict';

function ModalForm(url) {
	$("#form-modal").addClass('loading');
	$("#form-modal .modal-loading").show();
	$("#form-modal .modal-header").hide();
	$("#form-modal .modal-body").html('').load(url, function() {
		$("#form-modal .modal-loading").hide();
		$("#form-modal .modal-header .title").html($("#form-modal .modal-body span.title").html());
		$("#form-modal .modal-header").show();x
		$("#form-modal").removeClass('loading');
	});
	$("#form-modal").modal('show');
}

+function ($) {
	'use strict';

	// Close Alerts
	$(".alert").fadeTo(6000, 500).slideUp(500, function(){
		$(".alert").alert('close');
	});

	// Toogle Filter
	$('#filter-toogler').on('click', function(){
		$('#collection-wrapper .filters').toggleClass('open');
		$('#collection-wrapper .items').toggleClass('col-md-10 col-md-12');
	});

	// Menu Toogler with ESC key binding
	$('#drawer-wrapper').on('click', function(e){
		if (e.target !== this) {
			return;
		} else {
			$('#drawer-wrapper').toggle();
			$(".drawer").toggleClass('open');
		}
	});

	$('[role="menu-toggle"]').on('click', function() {
		$("#drawer-wrapper").toggle();
		setTimeout(function(){
			$(".drawer").toggleClass('open');
		},100);
	});

	$(document).keyup(function(e) {
		if (e.keyCode == 27 && $(".drawer").hasClass('open')) {
			$("#drawer-wrapper").toggle();
			setTimeout(function(){
				$(".drawer").toggleClass('open');
			},100);	
		}
	});

	// User dropdown toggler
	$('[role="user-toggle"]').on('click', function() {
		$("#header .user-dropdown").toggleClass('open');
	});

	// Form submit button
	$(document).on('click', '[role="submit"]', function(e) {
		var form = $($(e.currentTarget).data('form'));
		form.submit();
	});


	/*
	 * Table related code
	 */

	// Table check all rows
	$('#collection-wrapper .items').on('click', 'table th input', function(e) {
		var $target = $(e.currentTarget);
		$target.closest('table').find('input[type="checkbox"]').prop('checked', $target.prop('checked'));
		$target.closest('table').trigger('selection-change');

	});

	// Table check row
	$('#collection-wrapper .items').on('click', 'table td input', function(e) {
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

	$('#collection-wrapper .items').on('selection-change', 'table', function(e) {
		var $target = $(e.currentTarget);
		if ($target.find('tbody').find('td input[type="checkbox"]:checked').length) {
			$("#content-toolbar").addClass('show-bulk');
		} else {
			$("#content-toolbar").removeClass('show-bulk');
		}
	})


	// Table row click shortcut
	$('#collection-wrapper').on('click', 'tbody tr', function(e) {
		console.log($(e.target));
		if ($(e.target).is('.row-check, [type="checkbox"], .actions, .dropdown, .md-more-vert')) {
			return;
		}
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