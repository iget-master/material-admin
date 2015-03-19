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
	{!! HTML::style('css/app.css') !!}
</head>
<body>
	<div class="container-fluid">
		<div id="login-container" class="paper col-md-4 col-md-offset-4">
				@if (Session::get('alert'))
					<div class="alert alert-{!! Session::get('alert')["type"] !!}">
						{!! Session::get('alert')["message"] !!}
					</div>
				@endif

				{!! Form::open(array('route' => 'materialadmin.authenticate')) !!}
					<div class="form-group">
						{!! Form::label('email', 'Email:') !!}
						{!! Form::text('email', null, array('class' => 'form-control')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('password', 'Senha:') !!}
						{!! Form::password('password', array('class' => 'form-control')) !!}
					</div>
					{!! Form::button('<i class="md md-check"></i> Entrar', array('type'=>'submit', 'class' => 'btn btn-primary pull-right')) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>

	<!-- Scripts are placed here -->
    {!! HTML::script('//code.jquery.com/jquery-2.1.1.min.js') !!}
    {!! HTML::script('iget-master/material-admin/js/vendor/bootstrap.min.js') !!}
</body>
</html>