@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')

    <div id="card-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8 card">
                    <div class="header">
                        <div class="info">
                            <h1>@lang('materialadmin::user.new_user')</h1>
                        </div>
                        <div class="action">

                        </div>  
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Usuários</label>
                                    <div class="content-wrapper">
                                        <input id="typeahead" name="user_id" type="text" class="form-control"/>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
