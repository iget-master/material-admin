(function($) {
	$.fn.typeahead = function ( options ) {
		// Default plugin settings
		var settings = $.extend(true, {
			minLength: 1,
			inputDelay: 50,
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
			$field.data('typeahead', settings)
			.addClass('typeahead')
			.attr({
				autocomplete: "off",
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
			return this;
		},
		handleKeyboard: function(event)
		{
			var keyCode = event.keyCode || event.which;
			var $field = $(this);
			var $typeaheadBox = $(this).siblings('.typeahead-box');
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
				typeahead.field.set($field, $currentSelection.data('datum'));
				typeahead.suggestionBox.close($field).clear($field);
				event.preventDefault();
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
				$suggestionBox = $field.siblings('.typeahead-box');
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
				$field.siblings('.typeahead-box').html('');
				return this;
			},
			open: function ($field)
			{
				if ($field.is(":focus"))
				{
					$field.trigger('typeahead-box-open');

					$field.parent().removeClass('open').addClass('open');
					if (($field.siblings('.typeahead-box').find('li.typeahead-suggestion').length > 0) && ($field.siblings('.typeahead-box').find('li.typeahead-suggestion.active').length == 0))
					{
						$field.siblings('.typeahead-box').find('li.typeahead-suggestion').first().addClass('active');
					}
				}
				return this;
			},
			close: function ($field)
			{
				$field.parent().removeClass('open');
				return this;
			},
			empty: function ($field)
			{
				fieldSettings = $field.data('typeahead');
				$suggestionBox = $field.siblings('.typeahead-box').html('<li class="typeahead-empty"><a>' + fieldSettings.template.empty($field.val()) + '</a></li>');
				typeahead.suggestionBox.open($field);
			},
			searching: function ($field)
			{
				fieldSettings = $field.data('typeahead');
				$suggestionBox = $field.siblings('.typeahead-box').html('<li class="typeahead-searching"><a>' + fieldSettings.template.searching($field.val()) + '</a></li>');
				typeahead.suggestionBox.open($field);
			},
			handleSuggestionClick: function (event)
			{
				var $field = $(event.target).closest('ul.typeahead-box').siblings('input.typeahead')
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
				$field.parent().find('ul.typeahead-box').html('');

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
}( jQuery ))