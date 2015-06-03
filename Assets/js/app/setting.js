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

    // Push tab changes to history
    $('ul.nav-tabs').on('click', 'a', function() {
        var group = $(this).data('group');
        var url = window.location.href.split('?')[0] + '?active_tab=' + group;
        history.pushState({'active_tab': group}, '', url);
    });

    $(window).on('popstate', function(event) {
        var state = event.originalEvent.state;
        if (typeof state.active_tab !== 'undefined') {
            $('ul.nav-tabs a[data-group="' + state.active_tab + '"]').tab('show');
        }
    })
} (jQuery);