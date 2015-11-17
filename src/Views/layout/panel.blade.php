<!DOCTYPE html>
<html lang="en">
    <head>
    	<title>CDTSys v{!! config('admin.app_version') !!}</title>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- CSS are placed here -->
        {!! HTML::style('//fonts.googleapis.com/css?family=Roboto:300,400,500,700') !!}
        {!! HTML::style('iget-master/material-admin/css/bootstrap.min.css') !!}
        {!! HTML::style('iget-master/material-admin/css/material-design-iconic-font.min.css') !!}
        {!! HTML::style(versionedScriptUrl('iget-master/material-admin/css/panel.min.css')) !!}
        
        @yield('style')

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
                                <i class="zmdi zmdi-comment-text"></i>
                                <span class="badge">{!! Auth::user()->unreadMessagesCount() !!}</span>
                            @else
                                <i class="zmdi zmdi-comment-text"></i>
                            @endif
                        </a>
                        <a href="{!! route('materialadmin.logout') !!}" class="btn btn-flat">
                            <i class="zmdi zmdi-sign-in"></i>
                        </a>
                    </div>
                </div>
                <div class="context">
                    <div class="menu">
                        <button role="menu-toggle" class="btn btn-flat">
                            <i class="zmdi zmdi-menu"></i>
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
        @if(Request::has('debug'))
            <div id="debug" style="width: 100%; position: absolute; bottom: 0; text-align: center; font-size: 10px; background: white; opacity: 0.7;">
                Executed in {!! round(microtime(true) - LARAVEL_START, 3) !!} ms
            </div>
        @endif
    	<!-- Scripts are placed here -->
        {!! HTML::script('//code.jquery.com/jquery-2.1.1.min.js') !!}
        {!! HTML::script(versionedScriptUrl('js/app/fileupload.js')) !!}
        {!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/app/app.js')) !!}
        {!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/app/panel.js')) !!}
        {!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/vendor/bootstrap.min.js')) !!}
        {!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/vendor/bloodhound.js')) !!}
        {!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/vendor/typeahead.js')) !!}
        {!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/vendor/moment.min.js')) !!}
        {!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/vendor/locales.min.js')) !!}
        {!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/vendor/jquery.mask.js')) !!}
        {!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/app/masks.js')) !!}
        
        @yield('script')

        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
    </body>
</html>
