<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="google-signin-client_id" content="{!! config('services.google.client_id') !!}">

    <!-- CSS are placed here -->
	{!! HTML::style('//fonts.googleapis.com/css?family=Roboto:300,400,500,700') !!}
	{!! HTML::style('iget-master/material-admin/css/bootstrap.min.css') !!}
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
				<div class="col-md-12" style="text-align: center">
					<div class="g-signin2" data-onsuccess="onSignIn" style="display: inline-block"></div>
					<p class="privacy-policy" style="margin-top: 1rem;">Ao efetuar login, você concorda com nossa <a href="/privacy-policy">Politica de Privacidade</a>.</p>
				</div>
			</div>
		</div>
	</div>

	{{-- Scripts are placed here --}}
	<script>
		function onSignIn() {
			const id_token = googleUser.getAuthResponse().id_token;

			window.location = '/api/auth/logacy/google?id_token=' + id_token;
		}
	</script>
	<script src="https://apis.google.com/js/platform.js" async defer></script>
</body>
</html>
