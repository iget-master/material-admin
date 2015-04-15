@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="content-wrapper">
        <input id="typeahead" name="user_id" type="text" class="form-control"/>
	</div>
@stop

@section('title')
	<span>Home</span>
@stop

@section('toolbar')
@stop

@section('script')
    {!! HTML::script('iget-master/material-admin/js/vendor/bloodhound.js') !!}
    {!! HTML::script('iget-master/material-admin/js/vendor/typeahead.js') !!}
    <script>
        var userSearchEngine = new Bloodhound({
            name: 'user',
            remote: '/search/user/%QUERY',
            datumTokenizer: function(d) {
                return Bloodhound.tokenizers.whitespace(d.name);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
        userSearchEngine.initialize();

        $('#typeahead').typeahead( {
            source: userSearchEngine,
            highlight: true,
            selectOnce: true,
            template: {
                suggestion: function(d) {
                   return d.name + ' ' + d.surname;
                },
                empty: function(q) {
                    return 'Sem resultados para "' + q + '".';
                },
                searching: function(q) {
                    return 'Buscando por "' + q + '".';
                }
            },
            displayKey: function(d) {
                return d.name + ' ' + d.surname;
            }
        });
    </script>
@stop
