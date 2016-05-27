(function($) {
    $.fn.typeahead = function ( options ) {
        // Default plugin settings
        var settings = $.extend(true, {
            minLength: 1,
            inputDelay: 0,
            highlight: true,
            template: {
                suggestion: function(d) {
                    return d.value;
                },
                empty: function(q) {
                    return 'No results for "' + q + '".';
                },
                searching: function(q) {
                    return 'Searching for "' + q + '".';
                },
                footer: false
            },
            displayKey: function(d) {
                return d.value;
            },
            formatQuery: function($field) {
                return $field.val();
            },
            getDatumId: function(d) {
                return d.id;
            }
        }, options);

        // Initialise each element from set.
        this.each(function() {
            typeahead.init($(this), settings);
        })
    };

    var typeahead = {
        init: function($field, settings)
        {
            var rand = Math.random().toString(36).substr(2, 10);
            $field.data('typeahead', settings)
                .addClass('typeahead')
                .attr({
                    autocomplete: rand,
                    spellcheck: "false"
                })
                .after('<ul class="dropdown-menu typeahead-box"></ul>')
                .on('input', typeahead.handleChange)
                .on('blur', typeahead.handleBlur)
                .on('keydown', typeahead.handleKeyboard)
                .parent()
                .addClass('dropdown')
                .on('click', '.typeahead-suggestion', typeahead.suggestionBox.handleSuggestionClick);

            $field.siblings('.typeahead-box').on('mouseenter', '.typeahead-suggestion', typeahead.suggestionBox.handleSuggestionMouseenter);

            if (typeof settings.selected_datum == 'object')
            {
                typeahead.field.set($field, settings.selected_datum);
            }

            return this;
        },
        handleKeyboard: function(event)
        {
            var keyCode = event.keyCode || event.which;
            var $field = $(this);
            var $typeaheadBox = $(this).closest('.dropdown').find('.typeahead-box');
            var suggestionsCount = $typeaheadBox.find('li.typeahead-suggestion').length;
            var $currentSelection = $typeaheadBox.find('li.active');

            if (keyCode == 38) // Up arrow key
            {
                // Verify if current suggestion is first of the list, and overflow if true.
                if ($currentSelection.is(':first-child'))
                {
                    $typeaheadBox.find('li.typeahead-suggestion').last().addClass('active');
                    if (suggestionsCount > 1)
                    {
                        $currentSelection.removeClass('active');
                    }
                }
                else // Else, select previous suggestion
                {
                    $currentSelection.prev('li.typeahead-suggestion').addClass('active');
                    $currentSelection.removeClass('active');
                }
                event.preventDefault();
            }
            else if (keyCode == 40) // Down arrow key
            {
                // Verify if current suggestion is last of the list, and overflow if true.
                if ($currentSelection.is(':last-child'))
                {
                    $typeaheadBox.find('li.typeahead-suggestion').first().addClass('active');
                    if (suggestionsCount > 1)
                    {
                        $currentSelection.removeClass('active');
                    }
                }
                else // Else, select next suggestion
                {
                    $currentSelection.next('li.typeahead-suggestion').addClass('active');
                    $currentSelection.removeClass('active');
                }
                event.preventDefault();
            }
            else if (keyCode == 13) // Enter key: Select current suggestion
            {
                if (typeahead.suggestionBox.isOpen($field)) {
                    typeahead.field.set($field, $currentSelection.data('datum'));
                    typeahead.suggestionBox.close($field).clear($field);
                    event.preventDefault();
                }
            }
            else if (keyCode == 27) // Escape key: Close suggestion box
            {
                typeahead.suggestionBox.close($field);
                event.preventDefault();
            }
        },
        handleChange: function(event) // Handle changes in typeahead input field
        {
            $field = $(event.target);
            fieldSettings = $field.data('typeahead'); // Get typeahead settings for $field.

            typeahead.suggestionBox.clear($field);
            typeahead.suggestionBox.searching($field);
            $field.removeData('selected-datum').trigger('datum-reset');
            clearTimeout($field.data('timeout'));
            if ($field.val().trim().length >= fieldSettings.minLength)
            {
                $field.data('timeout', setTimeout(function() {
                    typeahead.getSuggestions($field);
                }, $field.data('typeahead').inputDelay));
            }
            else
            {
                typeahead.suggestionBox.close($field).clear($field);
            }
            return this;
        },
        handleBlur: function(event)
        {
            setTimeout(function() {
                $field = $(event.target);
                typeahead.suggestionBox.close($field);
                if ((typeof $field.data('selected-datum') == 'undefined') && ($field.val().length > 0))
                {
                    $field.addClass("error");
                    $field.trigger("datum-reset");
                }
            }, 200);
        },
        suggestionBox: {
            add: function($field, suggestions) {
                fieldSettings = $field.data('typeahead');
                $suggestionBox = $field.closest('.dropdown').find('.typeahead-box');
                $.each(suggestions, function(index, value) {
                    var suggestionHtml = fieldSettings.template.suggestion(value);
                    if (suggestionHtml)
                    {
                        if (fieldSettings.highlight)
                        {
                            var stringToBold = $field.val().trim().replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
                            suggestionHtml = suggestionHtml.replace(RegExp(stringToBold, 'gi'), '<strong>$&</strong>');
                        }
                        $('<li class="typeahead-suggestion"><a href="#">' + suggestionHtml + '</a></li>')
                            .data('datum', value)
                            .appendTo($suggestionBox);
                    }
                });
                if (typeof fieldSettings.template.footer === 'function') {
                    $('<li class="typeahead-footer"><a href="#">' + fieldSettings.template.footer(suggestions) + '</a></li>').appendTo($suggestionBox);
                }
                typeahead.suggestionBox.open($field);
                return this;
            },
            clear: function ($field) {
                $field.closest('.dropdown').find('.typeahead-box').html('');
                return this;
            },
            isOpen: function ($field) {
                return $field.closest('.dropdown').hasClass('open');
            },
            open: function ($field) {
                $suggestionBox = $field.closest('.dropdown').find('.typeahead-box');
                if ($field.is(":focus"))
                {
                    $field.trigger('typeahead-box-open');

                    $field.closest('.dropdown').removeClass('open').addClass('open');
                    if (($suggestionBox.find('li.typeahead-suggestion').length > 0) && ($suggestionBox.find('li.typeahead-suggestion.active').length == 0))
                    {
                        $suggestionBox.find('li.typeahead-suggestion').first().addClass('active');
                    }
                }
                return this;
            },
            close: function ($field) {
                $field.closest('.dropdown').removeClass('open');
                return this;
            },
            empty: function ($field) {
                fieldSettings = $field.data('typeahead');
                $suggestionBox = $field.closest('.dropdown').find('.typeahead-box').html('<li class="typeahead-empty"><a>' + fieldSettings.template.empty($field.val()) + '</a></li>');
                typeahead.suggestionBox.open($field);
            },
            searching: function ($field)
            {
                fieldSettings = $field.data('typeahead');
                $suggestionBox = $field.closest('.dropdown').find('.typeahead-box').html('<li class="typeahead-searching"><a>' + fieldSettings.template.searching($field.val()) + '</a></li>');
                typeahead.suggestionBox.open($field);
            },
            handleSuggestionClick: function (event)
            {
                var $field = $(event.target).closest('.dropdown').find('input.typeahead');
                typeahead.field.set($field, $(event.target).closest('li.typeahead-suggestion').data('datum'));
                typeahead.suggestionBox.close($field).clear($field);
                event.preventDefault();
                event.stopPropagation();
            },
            handleSuggestionMouseenter: function (event)
            {
                $(this).siblings('.typeahead-suggestion').removeClass('active');
                $(this).addClass('active');
            }
        },
        field: {
            set: function ($field, datum)
            {
                fieldSettings = $field.data('typeahead');
                $field.data('selected-datum', datum)
                    .val(fieldSettings.displayKey(datum))
                    .removeClass('error');
                $field.trigger('datum-selected');
            }
        },

        getSuggestions: function($field, s)
        {
            fieldSettings = $field.data('typeahead');

            fieldSettings.source.get(fieldSettings.formatQuery($field).trim(), function(s){
                $field.closest('.dropdown').find('ul.typeahead-box').html('');

                if (s.length > 0)
                {
                    typeahead.suggestionBox.add($field, s);
                }
                else
                {
                    typeahead.suggestionBox.empty($field);
                }
            });

            return this;
        }
    }

    // Create fake inputs for typeahead before form submitting
    $(document).on('submit', function(event) {
        $('.typeahead').each(function() {
            var $field = $(this);
            fieldSettings = $field.data('typeahead');

            if ($field.attr('disabled')) {
                return;
            }
            
            var selected = $field.data('selected-datum');
            var $fake = $('<input type="hidden" role="typeahead-fake"/>').attr('name', $field.attr('name')).insertBefore($field);
            if (typeof selected !== 'undefined') {
                $fake.val(fieldSettings.getDatumId(selected));
            }
            $field.removeAttr('name');
        })
    });
}( jQuery ));
