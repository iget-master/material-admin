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
        {!! HTML::style(versionedFileUrl('css/vendor/sweetalert.min.css')) !!}
        {!! HTML::style(versionedFileUrl('css/panel.min.css')) !!}

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
                <div class="global" @if(app()->environment('local')) style="background-color: #FF5555" @endif>
                    <img class="brand" src="{{ config('admin.brand_image_url') }}">
                    <div class="actions">
                        @if (\IgetMaster\MaterialAdmin\Services\MotdService::getMotd())
                            <p class="motd">
                                {!! \IgetMaster\MaterialAdmin\Services\MotdService::getMotd() !!}
                            </p>
                        @endif
                        <a href="{!! route('message.index') !!}" id="user-messages" class="btn btn-flat">
                            @if ($unread_count = Auth::user()->unreadMessagesCount())
                                <i class="zmdi zmdi-comment-text"></i>
                                <span class="badge">{!! Auth::user()->unreadMessagesCount() !!}</span>
                            @else
                                <i class="zmdi zmdi-comment-text"></i>
                            @endif
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-flat dropdown-toggle" data-toggle="dropdown">
                                <i class="zmdi zmdi-more-vert"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
                                <li>
                                    <a href="{!! route('user.edit_password') !!}">
                                        <i class="zmdi zmdi-key"></i> <span>@lang('materialadmin::admin.update_password')</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{!! route('materialadmin.logout') !!}">
                                        <i class="zmdi zmdi-sign-in"></i> <span>@lang('materialadmin::admin.logout')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
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
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.js"></script>
        <script type="text/javascript" src="{!! versionedFileUrl('js/vendor/compiled.min.js') !!}"></script>
        <script type="text/javascript" src="{!! versionedFileUrl('js/app/compiled.min.js') !!}"></script>
        @include('materialadmin::panel.modal.session')
        @yield('script')

        <script>
            {{-- See session.js --}}
            var SessionLifetime = "{!! config('session.lifetime') !!}";
            var LoginUrl = "{!! route('materialadmin.login', ['expired' => true]) !!}";
            var LogoutUrl = "{!! route('materialadmin.logout') !!}";
        </script>

        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip({
                    delay: { "show": 100, "hide": 100 }
                })
            })
        </script>
    </body>
</html>
