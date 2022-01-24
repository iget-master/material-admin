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
