@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('title')
	<a href="/user" class="">@lang('materialadmin::user.title')</a>
	<i class="md md-navigate-next"></i>
	@lang('materialadmin::user.add_title')
@stop

@section('content')
	<div id="card-wrapper" ng-app="createView">
		<div class="container" ng-controller="createViewController">
			<div class="row">
				<div class="col-md-offset-2 col-md-8 card">
					<div class="header">
						<div class="col-md-2" id="image_content">
							<div>
								<i class="fa fa-pencil edit-default" ng-click="changeImage()"></i>
							</div>
							@if (Request::old('img_url'))
								<img class="img-circle hide" id="user_image" src="/user/{!! Request::old('image') !!}/temp">	
							@else
								<img class="img-circle" id="user_image" src="/iget-master/material-admin/imgs/user-image.jpg">	
							@endif
							
						</div>
						<div class="col-md-10">
							<div class="info">
								<h1>@lang('materialadmin::user.new_title')</h1>
							</div>
						</div>
					</div>
					<div class="body">
						@include('materialadmin::panel.alerts')
						{!! Form::open(array('route' => 'user.store', 'id' => 'user', 'files'=>true)) !!}
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										{!! Form::label('permission_group_id', trans('materialadmin::user.permission_group'), array('class' => 'required')) !!}
										{!! Form::select('permission_group_id', $permission_groups, null, array('class' => 'form-control', 'ng-model' => 'user.permission_group_id')) !!}
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										{!! Form::label('name', trans('materialadmin::user.name'), array('class' => 'required')) !!}
										{!! Form::text('name', null, array('class' => 'form-control', 'ng-model' => 'user.name')) !!}
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										{!! Form::label('surname', trans('materialadmin::user.surname'), array('class' => 'required')) !!}
										{!! Form::text('surname', null, array('class' => 'form-control', 'ng-model' => 'user.surname')) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										{!! Form::label('dob', trans('materialadmin::user.dob')) !!}
										{!! Form::input('date', 'dob', null, array('class' => 'form-control', 'ng-model' => 'user.dob')) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{!! Form::label('language', trans('materialadmin::user.default_language'), array('class' => 'required')) !!}
										{!! Form::select('language', IgetMaster\MaterialAdmin\Helper::getLanguagesSelectOptions(), null, array('class' => 'form-control', 'ng-model' => 'user.language')) !!}
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group" id="email-content">
										{!! Form::label('email', trans('materialadmin::user.email'), array('class' => 'required')) !!}
										{!! Form::text('email', null, array('class' => 'form-control', 'ng-model' => 'user.email', 'ng-change' => 'checkEmail(user)')) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 hidden">
									<div class="form-group">
										{!! Form::label('image', trans('materialadmin::user.img_url')) !!}
										{!! Form::file('image', ['id' => 'image', 'accept' => 'image/*']) !!}
									</div>
								</div>
								{!! Form::hidden('img_url', NULL, ['id' => 'img_url']) !!}
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group" id="pass1-content">
										{!! Form::label('password', trans('materialadmin::user.password'), array('class' => 'required')) !!}
										{!! Form::password('password', array('class' => 'form-control', 'ng-model' => 'user.password', 'ng-change' => 'checkPasswords(user)')) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group" id="pass2-content">
										{!! Form::label('password_confirmation', trans('materialadmin::user.password_confirmation'), array('class' => 'required')) !!}
										{!! Form::password('password_confirmation', array('class' => 'form-control', 'ng-model' => 'user.password_confirmation', 'ng-change' => 'checkPasswords(user)')) !!}
									</div>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
					<div class="footer">
						<a href="/user" class="btn btn-flat">@lang('materialadmin::admin.action_cancel')</a>
						<a class="btn btn-flat action" ng-disabled="saveDisabled(user)" ng-click="submit(user)">@lang('materialadmin::admin.action_create')</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('script')
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.16/angular.min.js"></script>
	{!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/app/users.js')) !!}
	{!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/app/errors.js')) !!}

	@if ($errors->any())
		<script>
			$('form#user').formErrorParser({}, {!! $errors->toJson(); !!});
		</script>
	@endif

	<script>
	$("#user_image").on('load', function(e) {
		$(e.target).removeClass('hide');
	});
	
	// Mensagem de erro do upload de imagens
	var error_message = "{!! trans('materialadmin::user.invalid_image') !!}";

	// Regex para validar e-mail
	var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

	// Traz as requisições anteriores em caso de erro
	var oldUser = {!! json_encode(\Request::old()) !!};
	
	// Altera a data de yyyy-MM-dd HH:MM:ss para yyyy-MM-dd
	if (oldUser.dob) {
		oldUser.dob = new Date(oldUser.dob);
	}

	angular.module("createView", []);
	angular.module("createView").controller("createViewController", function($scope, $http){
		// Define o scope user = dados Old
		$scope.user = oldUser;

		// Define o nome de arquivo temporario para null
		var tempName = "";

		// Cria timeouts para email e senha
		var timeoutEmail, timeoutPasswords;
		
		// Define status default
		var statusCheckEmail = false, statusCheckPasswords = false, statusImage = true;
		if(oldUser.length != 0){
			statusCheckEmail = true;
			statusCheckPasswords = true;
		}

		// Clica no input=file quando a houver um click na imagem
		$scope.changeImage = function() {
			$("#image").click();
		};

		// Verifica se o email é válido
		$scope.checkEmail = function(user){
			if(user && user.email){
				clearTimeout(timeoutEmail);
				timeoutEmail = setTimeout(function(){
					$scope.$apply(function(){
						if(re.exec(user.email) != null){
							$("#email-content").removeClass('has-error');
							statusCheckEmail = true;
							// remove o markup de erro.
							$("#email-content .input-group").removeClass('has-error');
							$("#email-content .input-group span").empty();
						} else {
							$("#email-content").addClass('has-error');
							statusCheckEmail = false;
						}
					});
				}, 1500);
			} else {
				$("#email-content").removeClass('has-error');
				statusCheckEmail = false;
			}
		}

		// Verifica se as senhas informadas são validas e iguais
		$scope.checkPasswords = function(user){
			if(user && user.password && user.password_confirmation){
				clearTimeout(timeoutPasswords);
				timeoutPasswords = setTimeout(function(){
					$scope.$apply(function(){
						if((user.password.length > 5) && (user.password_confirmation.length > 5)){
							//senhas estao no tamanho correto
							if(user.password === user.password_confirmation){
								//pass 1 e pass 2 sao iguais
								$("#pass1-content").removeClass('has-error');
								$("#pass2-content").removeClass('has-error');

								// remove o markup de erro.
								$("#pass1-content .input-group").removeClass('has-error');
								$("#pass1-content .input-group span").empty();

								statusCheckPasswords = true;
							} else {
								//pass 1 e diferente de pass 2
								$("#pass1-content").addClass('has-error');
								$("#pass2-content").addClass('has-error');
								statusCheckPasswords = false;
							}
						} else {
							//tamanho das senhas e <= 5
							$("#pass1-content").addClass('has-error');
							$("#pass2-content").addClass('has-error');
							statusCheckPasswords = false;
						}
					});
				}, 1500);
			} else if(!user || (!user.password && !user.password_confirmation)){
				// nao tem nada cadastrado
				$("#pass1-content").removeClass('has-error');
				$("#pass2-content").removeClass('has-error');
				statusCheckPasswords = false;
			} else if(!user.password || (user.password.length < 6)) {
				//nao tem o pass 1
				$("#pass1-content").addClass("has-error");
				statusCheckPasswords = false;
			} else if(!user.password_confirmation || (user.password.length < 6)){
				//nao tem o pass 2
				$("#pass2-content").addClass("has-error");
				statusCheckPasswords = false;
			}
		}

		// Executa quando for selecionado alguma imagem no input=file
		$("#image").on('change', function(){
			// Pega a imagem selecionada
			var f = document.getElementById('image').files[0];
			
			// Se nenhum arquivo foi escolhido, sai da função.	
			if(typeof f == 'undefined') {
				return;
			}

			// verifica se o arquivo selecionado é uma imagem
			if(f.type == 'image/png' || f.type == 'image/jpg' || f.type == 'image/jpeg'){

				// Cria um FormData
				var fm = new FormData();
				// Adiciona a imagem no FormData
				fm.append("file", f);
				// Se houver um nome de arquivo temporario adiciona no FormData tambem
				if(tempName.length > 0){
					fm.append("temp", tempName);
				}

				// Via ajax envia o FormData
				$http.post("/user/photo/temp", fm, {
					headers: {
						'Content-type': undefined
					},
					transformRequest: angular.identity
				}).success(function(response){
					// Altera a src da imagem para exibir o arquivo temporario
					$("#user_image").attr("src", "/user/"+response+"/temp").addClass('hide');
					// Altera o value do input=hidden da imagem para o arquivo temporario
					$("#img_url").attr("value", response);
				});
				$scope.$apply(function(){
					statusImage = true;
				});
			} else {
				window.alert(error_message);
			}
		});

		// Verifica se o botao ficará disabled
		$scope.saveDisabled = function(user){
			console.log(statusCheckEmail, statusCheckPasswords, statusImage, user.permission_group_id, user.name, user.surname, user.dob, user.language)
			if(statusCheckEmail && statusCheckPasswords && statusImage && user.permission_group_id && user.name && user.surname && user.dob && user.language){
				return false;
			}
			return true;
		};

		// Envia formulário
		$scope.submit = function(user){
			$("#user").submit();
		}

	});

	// Altera estilo do icone ṕara editar image de usuario
	$("#image_content").on('mouseover', function(){
		$("#change_image").removeClass("edit-default").addClass("edit-active");
	}).on('mouseleave', function(){
		$("#change_image").removeClass("edit-active").addClass("edit-default");
	});
	</script>
@stop
