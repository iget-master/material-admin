<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSS are placed here -->
    {!! HTML::style('packages/iget-master/materialadmin/css/bootstrap.css') !!}
    {!! HTML::style('packages/iget-master/materialadmin/css/bootstrap-theme.css') !!}
    {!! HTML::style('css/app.css') !!}
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				@if (Auth::check())
					Seja bem vindo, {!! Auth::user()->name !!}. {!! link_to_route('session.destroy', 'Sair')!!}
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				@if (Session::get('alert'))
					<div class="alert alert-{!! Session::get('alert')["type"] !!}">
						{!! Session::get('alert')["message"] !!}
					</div>
				@endif
			</div>
		</div>
		@yield('content')
	</div>

	<!-- Scripts are placed here -->
    {!! HTML::script('//code.jquery.com/jquery-2.1.1.min.js') !!}
    {!! HTML::script('packages/iget-master/materialadmin/js/bootstrap.min.js') !!}
</body>
</html>