<!DOCTYPE html>
<html lang="en">
    <head>
    	<title>CDTSys</title>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- CSS are placed here -->
        {!! HTML::style('http://fonts.googleapis.com/css?family=Roboto:300,400,500,700') !!}
        {!! HTML::style('iget-master/material-admin/css/bootstrap.min.css') !!}
        {!! HTML::style('iget-master/material-admin/css/material-design-iconic-font.min.css') !!}
        {!! HTML::style('iget-master/material-admin/css/panel.min.css') !!}
        {!! HTML::style('css/app.css') !!}
    </head>
    <body>
        <div id="app">
            <div id="drawer-wrapper">
                @include('materialadmin::panel.menu')            
            </div>
            <div id="header-wrapper">
                <div class="global">
                    <img class="brand" src="http://placehold.it/120x40">
                    <div class="actions">
                        <a href="/message/" id="user-messages" class="btn btn-flat dropdown-toggle">
                            @if ($unread_count = Auth::user()->unreadMessages->count())
                                <i class="md md-message new"></i>
                            @else
                                <i class="md md-message"></i>
                            @endif
                        </a>
                    </div>
                </div>
                <div class="context">
                    <div class="menu">
                        <button role="menu-toggle" class="btn btn-flat">
                            <i class="md md-menu"></i>
                        </button>
                    </div>
                    <div class="title">
                        <h1>@yield('title')</h1>
                    </div>
                    <div class="actions">
                        @yield('actions')
                    </div>
                </div>
            </div>
            <div id="content-wrapper">
                @yield('content')
                <div class="floating">
                    @yield('floating')
                </div>
            </div>
        </div>
    	<!-- Scripts are placed here -->
        <!-- {!! HTML::script('//code.jquery.com/jquery-2.1.1.min.js') !!} -->
        {!! HTML::script('iget-master/material-admin/js/vendor/jquery.min.js') !!}
        {!! HTML::script('iget-master/material-admin/js/app/app.js') !!}
        {!! HTML::script('iget-master/material-admin/js/app/panel.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/bootstrap.min.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/bloodhound.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/typeahead.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/moment.min.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/locales.min.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/bootstrap-datetimepicker.min.js') !!}
        
        @yield('script')
        @include('materialadmin::panel.modal')
    </body>
</html>