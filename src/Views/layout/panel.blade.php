<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <!-- CSS are placed here -->
    {!! HTML::style('http://fonts.googleapis.com/css?family=Roboto:300,700,400') !!}
    {!! HTML::style('packages/iget-master/materialadmin/css/bootstrap.css') !!}
    {!! HTML::style('packages/iget-master/materialadmin/css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('packages/iget-master/materialadmin/css/admin.css') !!}
    {!! HTML::style('css/app.css') !!}
</head>
<body>
    <!-- Panel Header bar -->
	<div id="header">
        <div class="menu">
            <button role="menu-toggle" class="btn btn-lg btn-transparent">
                <i class="md md-menu md-lg"></i>
            </button>
        </div>
        <div class="title">
            <span>@yield('title')</span>
        </div>
        <div class="toolbar">
            <button role="user-toggle" class="btn btn-lg btn-transparent">
                <i class="md md-person md-lg"></i>
            </button>
            <div class="user-dropdown">
                <div class="arrow-up"></div>
                <span class="name">{!! Auth::user()->name!!}</span>
                <span class="email">{!! Auth::user()->email !!}</span>
                {!! link_to_route('materialadmin.logout', 'Logout') !!}
            </div>
        </div>
    </div>
    @include('materialadmin::panel.menu');

    <div class="container" id="content">
        @yield('content')
    </div>

    <div id="content-toolbar">
        @yield('toolbar')
    </div>

	<!-- Scripts are placed here -->
    {!! HTML::script('//code.jquery.com/jquery-2.1.1.min.js') !!}
    {!! HTML::script('packages/iget-master/materialadmin/js/app/app.js') !!}
    {!! HTML::script('packages/iget-master/materialadmin/js/app/panel.js') !!}
    {!! HTML::script('packages/iget-master/materialadmin/js/bootstrap.min.js') !!}
    @yield('script')
</body>
</html>