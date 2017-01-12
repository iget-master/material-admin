<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSS are placed here -->
	{!! HTML::style('//fonts.googleapis.com/css?family=Roboto:300,400,500,700') !!}
	{!! HTML::style('iget-master/material-admin/css/bootstrap.min.css') !!}
	{!! HTML::style('iget-master/material-admin/css/material-design-iconic-font.min.css') !!}
	{!! HTML::style(versionedFileUrl('css/vendor/sweetalert.min.css')) !!}
	{!! HTML::style(versionedFileUrl('css/panel.min.css')) !!}
</head>
<body style="background-color: #2196f3">
	<div class="container-fluid" id="login-wrapper">
		<div id="login-card">
            <div class="text-center" style="margin-bottom: 25px;">
                <img src="img/logo-120.png" alt="CDTSys"/>
            </div>
			@if (Session::get('alert'))
				<div class="alert permanent alert-{!! Session::get('alert')["type"] !!}">
				{!! Session::get('alert')["message"] !!}
			</div>
			@endif
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(array('route' => 'materialadmin.authenticate')) !!}
					<div class="form-group">
						{!! Form::label('email', 'Email:') !!}
						{!! Form::text('email', null, array('class' => 'form-control')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('password', 'Senha:') !!}
						{!! Form::password('password', array('class' => 'form-control')) !!}
					</div>
					<br>
					<div class="text-center">
						{!! Form::button('<i class="zmdi zmdi-check"></i> Entrar', array('type'=>'submit', 'class' => 'btn btn-raised btn-block')) !!}
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>

	{{-- Scripts are placed here --}}
	<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="{!! versionedFileUrl('js/vendor/compiled.min.js') !!}"></script>
	<script type="text/javascript" src="{!! versionedFileUrl('js/app/compiled.min.js') !!}"></script>
</body>
</html>
