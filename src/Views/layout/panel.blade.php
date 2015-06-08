<!DOCTYPE html>
<html lang="en">
    <head>
    	<title>CDTSys v{!! config('admin.app_version') !!}</title>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- CSS are placed here -->
        {!! HTML::style('http://fonts.googleapis.com/css?family=Roboto:300,400,500,700') !!}
        {!! HTML::style('iget-master/material-admin/css/bootstrap.min.css') !!}
        {!! HTML::style('iget-master/material-admin/css/material-design-iconic-font.min.css') !!}
        {!! HTML::style('iget-master/material-admin/css/panel.min.css') !!}
        <link rel="icon" type="img/png" href="/img/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="img/png" href="/img/favicon-16x16.png" sizes="16x16" />
    </head>
    <body>
        <div id="app">
            <div id="drawer-wrapper">
                @include('materialadmin::panel.menu')            
            </div>
            <div id="header-wrapper">
                <div class="global">
                    <img class="brand" src="{{ config('admin.brand_image_url') }}">
                    <div class="actions">
                        <a href="{!! route('message.index') !!}" id="user-messages" class="btn btn-flat">
                            @if ($unread_count = Auth::user()->unreadMessagesCount())
                                <i class="md md-message"></i>
                                <span class="badge">{!! Auth::user()->unreadMessagesCount() !!}</span>
                            @else
                                <i class="md md-message"></i>
                            @endif
                        </a>
                        <a href="{!! route('materialadmin.logout') !!}" class="btn btn-flat">
                            <i class="md md-exit-to-app"></i>
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
        {!! HTML::script('//code.jquery.com/jquery-2.1.1.min.js') !!}
        {!! HTML::script('iget-master/material-admin/js/app/app.js') !!}
        {!! HTML::script('iget-master/material-admin/js/app/panel.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/bootstrap.min.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/bloodhound.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/typeahead.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/moment.min.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/locales.min.js') !!}
        {!! HTML::script('iget-master/material-admin/js/vendor/jquery.mask.js') !!}
        {!! HTML::script('iget-master/material-admin/js/app/masks.js') !!}
        
        @yield('script')
        @include('materialadmin::panel.modal')
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
    </body>
</html>
