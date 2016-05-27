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

+function ($) {
    'use strict';

    /**
     * jQuery.fn.formErrorParser
     */
    $.fn.formErrorParser = function ( options, errors ) {
        // Options extends default options
        options = $.extend(true,
        {
            inputWrapper: '<div class="input-group"></div>',
            inputWrapperErrorClass: 'has-error',
            inputAddon: '<span class="input-group-addon error-addon"><i class="zmdi zmdi-alert-circle" data-toggle="tooltip" data-placement="auto"></i></span>',
        },
        options);

        $(this).data('error-parser', new FormErrorParser(this, options, errors));



    };

    /**
     * FormErrorParser
     */

    var FormErrorParser = function( form, options, errors ) {
        this.$form = $(form);
        this.options = options;

        if (typeof errors !== 'undefined') {
            this.parseErrors(errors);
        }
    };

    FormErrorParser.prototype.parseErrors = function (errors) {
        $.each(errors, this.appendInputError.bind(this));
    };

    FormErrorParser.prototype.appendInputError = function (raw_field_name, error) {
        // Convert Laravel '.' notation to '[]' notation
        raw_field_name = raw_field_name.split('.');
        var field_name = raw_field_name.shift();

        $.each(raw_field_name, function(index, value) {
            field_name = field_name + '[' + value + ']';
        });

        var $field = this.$form.find('[name="' + field_name + '"]');
        if ($field.hasClass('fake-typeahead')) {
            $field = $field.siblings('.typeahead');
        }
        if ($field.parent('.input-group').length == 0) {
            $field.wrap(this.options.inputWrapper);
        }
        
        var $addon = $(this.options.inputAddon).insertAfter($field);
        $addon.find('i').attr('title', error).tooltip();

        $field.parent('.input-group').addClass(this.options.inputWrapperErrorClass);

        // If field is in a tab-panel, put the error class in the tab link.
        var $tab = $field.closest('.tab-pane');
        if ($tab.length) {
            var $tabLink = $('[href="#' + $tab.attr('id') + '"]');
            $tabLink.closest('li').addClass('has-error');
            if (typeof this.tabFocused == 'undefined') {
                $tabLink.click();
                this.tabFocused = true;
            }
        }

        // If field is in a collapse panel, open it to make sure that user will see the error.
        $field.closest('.panel-collapse.collapse:not(.in)').addClass('in');
   }
} (jQuery);

$('.mask-percent').mask('0.000.000.000,00', {reverse:true});
$('.mask-float').mask("0.000.000.000,00", {reverse:true});
$('.mask-integer').mask("00.000.000.000", {reverse:true});
$('.mask-phone').mask('+00 00000000000000');
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

	$('#collection-wrapper').on('selection-change', 'table', function(e) {
		var $target = $(e.currentTarget);
		if ($target.find('tbody').find('td input[type="checkbox"]:checked').length) {
			$('#bulk-actions-toggle').removeClass('disabled');
		} else {
            $('#bulk-actions-toggle').addClass('disabled');
		}
	}).find('table').trigger('selection-change');

	// Table row click shortcut
	$('#collection-wrapper').on('click', 'tbody tr', function(e) {
		if ($(e.target).is('.row-check, [type="checkbox"], .actions, .dropdown, .zmdi-more-vert')) {
			return;
		}
		var $edit = $(e.currentTarget).find('[role="edit"]');
		if ($edit.length) {
			var href = $(e.currentTarget).find('[role="edit"]').attr('href');
			window.location = href;
		}
	});

	$("#collection-wrapper table.index-table").on('selection-change', function(event) {
        var $form = $('#bulk-destroy');
        $form.find('input[name="remove_ids[]"]').remove();

        $("#collection-wrapper table.index-table tbody").find('input[type="checkbox"]:checked').each(function() {
            $form.append('<input type="hidden" name="remove_ids[]" value="' + $(this).closest('tr').data('id') + '">');
        });
    })

    $("#do-bulk-destroy").on('click', function(event) {
        var $form = $('#bulk-destroy');
        if ($form.find('input[name="remove_ids[]"]').length) {
            $form.submit();
        }
        event.preventDefault();
    });
} (jQuery)
+function ($) {
    'use strict';

    var $settingGroups = $('#settings-groups');
    
    if (!$settingGroups.length) {
        return;
    }

    // Bind edit and delete actions for each Setting Item <li>
    $settingGroups.on('click', '.editable a, li.editable, tr.editable, .delete-only a', function(e) {
        var $target = $(e.currentTarget);

        if ($target.hasClass('edit') || $target.hasClass('editable')) {
            window.location.href = $target.closest('.editable').data('edit');
        } else if ($target.hasClass('delete')) {
            window.location.href = $target.closest('.list-group-item').data('delete');
        }
        e.stopPropagation();
    });

    // Bind create action for each Setting Item
    $settingGroups.on('click', '.settings-item a.create', function(e) {
        var $currentTarget = $(e.currentTarget);

        if ($currentTarget.attr('href') == '#') {
            window.location.href = $currentTarget.closest('.settings-item').data('create');
        }
    });

    // Bind show action for each Setting Item
    $settingGroups.on('click', '.settings-item a.show', function(e) {
        window.location.href = $(e.currentTarget).closest('.settings-item').data('show');
    });

    // Push tab changes to history
    $('ul.nav-tabs').on('click', 'a', function() {
        var group = $(this).data('group');
        var url = window.location.href.split('?')[0] + '?active_tab=' + group;
        history.pushState({'active_tab': group}, '', url);
    });

    $(window).on('popstate', function(event) {
        var state = event.originalEvent.state;
        if (state !== null && typeof state.active_tab !== 'undefined') {
            $('ul.nav-tabs a[data-group="' + state.active_tab + '"]').tab('show');
        }
    });
} (jQuery);

var alertError = function(text) {
    swal({
        title: "Error!",
        text: text,
        type: "error",
        allowOutsideClick: true
    });
};
//# sourceMappingURL=compiled.min.js.map
