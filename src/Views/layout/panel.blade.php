<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <!-- CSS are placed here -->
    {!! HTML::style('http://fonts.googleapis.com/css?family=Roboto:300,700,400') !!}
    {!! HTML::style('iget-master/material-admin/css/bootstrap.css') !!}
    {!! HTML::style('iget-master/material-admin/css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('iget-master/material-admin/css/admin.css') !!}
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
        {!! Form::open(['route'=>'message.index']) !!}
            <button role="messages" type='submit' class="btn btn-lg btn-transparent">
                <i class="md md-message md-lg"></i>
            </button>
        {!! Form::close() !!}
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
    {!! HTML::script('iget-master/material-admin/js/app/app.js') !!}
    {!! HTML::script('iget-master/material-admin/js/app/panel.js') !!}
    {!! HTML::script('iget-master/material-admin/js/vendor/bootstrap.min.js') !!}
    {!! HTML::script('iget-master/material-admin/js/vendor/bloodhound.js') !!}
    {!! HTML::script('iget-master/material-admin/js/vendor/typeahead.js') !!}
    @yield('script')

    @include('materialadmin::panel.modal');
</body>
</html>