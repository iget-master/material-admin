@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('title')
	<a href="/user" class="">@lang('materialadmin::user.title')</a>
	<i class="md md-navigate-next"></i>
	@lang('materialadmin::user.edit_title')
@stop

@section('content')
	<div id="card-wrapper" ng-app="editView">
		<div class="container" ng-controller="editViewController">
			<div class="row">
				<div class="col-md-offset-2 col-md-8 card">
					<div class="header">
						<div class="col-md-2" id="image_content">
							<div>
								<i class="fa fa-pencil edit-default" ng-click="changeImage()"></i>
							</div>
							<img alt="{!! $user->name !!}" class="img-circle hide" id="user_image">
						</div>
						<div class="col-md-10">
							<div class="info">
								<h6 class="helper">@lang('materialadmin::admin.now_editing')</h6>
								<h1>{!! $user->name !!} {!! $user->surname !!}</h1>
								<h4>{!! $user->email !!}</h4>
							</div>
							<div class="action">
								{!! Form::open(array('method'=>'DELETE', 'route' => array('user.destroy', $user->id))) !!}
									<button type="submit" class="btn btn-flat" data-toggle="tooltip" data-placement="bottom" title="@lang('materialadmin::user.delete_this_title')"><i class="md md-delete"></i></button>
								{!! Form::close() !!}
							</div>
						</div>
					</div>
					<div class="body">
						@include('materialadmin::panel.alerts')
						{!! Form::open(['method'=>'PATCH', 'route'=>['user.update', $user->id], 'id'=>'user', 'files'=>true]) !!}
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
										{!! getFormatedDate($user->dob, true) !!}
										{!! Form::input('date', 'dob', getFormatedDate($user->dob, true), array('class' => 'form-control', 'ng-model' => 'user.dob')) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{!! Form::label('language', trans('materialadmin::user.default_language'), array('class' => 'required')) !!}
										{!! Form::select('language', IgetMaster\MaterialAdmin\Helper::getLanguagesSelectOptions(), null, array('class' => 'form-control', 'ng-model' => 'user.language')) !!}
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group" id="email-content">
										{!! Form::label('email', trans('materialadmin::user.email'), array('class' => 'required')) !!}
										{!! Form::text('email', null, array('class' => 'form-control', 'disabled'=>'true', 'ng-model' => 'user.email')) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 hidden">
									<div class="form-group">
										{!! Form::label('image', trans('materialadmin::user.img_url')) !!}
										{!! Form::file('image', ['id' => 'image', 'accept'=>'image/*']) !!}
									</div>
								</div>
								{!! Form::hidden('img_url', NULL, ['id' => 'img_url']) !!}
							</div>
							<div class="row enable">
								<div class="col-md-12">
									<div class="form-group option">
										<input type="checkbox" name="enable-paid" role="enable" data-target="#password-container" ng-model="change_passwords" ng-change="disableSubmit()">
										<span class="text">@lang('materialadmin::user.change_password')</span>
									</div>
								</div>
							</div>
							<div id="password-container" class="row disabled">
								<div class="col-md-3">
									<div class="form-group" id="pass1-content">
										{!! Form::label('password', trans('materialadmin::user.password'), array('class' => 'required')) !!}
										{!! Form::password('password', array('class' => 'form-control', 'ng-model' => 'user.password', 'ng-change' => 'checkPasswords(user)')) !!}
										@if ($errors->has('password'))
											{!! $errors->firs#user_imaget('password') !!}
										@endif
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group" id="pass2-content">
										{!! Form::label('password_confirmation', trans('materialadmin::user.password_confirmation'), array('class' => 'required')) !!}
										{!! Form::password('password_confirmation', array('class' => 'form-control', 'ng-model' => 'user.password_confirmation', 'ng-change' => 'checkPasswords(user)')) !!}
										@if ($errors->has('password_confirmation'))
											{!! $errors->first('password_confirmation') !!}
										@endif
									</div>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
					<div class="footer">
						<a href="/user" class="btn btn-flat">@lang('materialadmin::admin.action_discard')</a>
						<a class="btn btn-flat action" ng-disabled="saveDisabled(user)" ng-click="submit(user)">@lang('materialadmin::admin.action_save')</a>
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

	// Regex para validar e-mail
	var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

	// Define os dados a serem editados pelos usuários
	var user = {!! json_encode($user); !!};

	angular.module("editView", []);
	angular.module("editView").controller("editViewController", function($scope, $http){
		// Define o scope com os dados do usuário
		$scope.user = user;

		// Altera a data de yyyy-MM-dd HH:MM:ss para yyyy-MM-dd
		$scope.user.dob = new Date($scope.user.dob);

		// Pega o id do usuario e a imagem
		var userId = <?php echo $user->id; ?>;

		// Insere a src na imagem do formulario se houver imagem cadastrada
		@if($user->img_url)
			$("#user_image").attr("src", "/user/"+userId+"/photo");
		@else
			$("#user_image").attr("src", "/iget-master/material-admin/imgs/user-image.jpg");
		@endif

		// Define o nome de arquivo temporario para null
		var tempName = "";

		// Cria timeouts para senha
		var timeoutPasswords;
		
		// Define status default
		var statusCheckPasswords = true, statusImage = true;

		// Desabilita/Habilita o submit se o box de alterar senha for marcado/desmarcado
		$scope.disableSubmit = function(){
			if($scope.change_passwords){
				statusCheckPasswords = false;
			} else {
				statusCheckPasswords = true;
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
			var f = document.getElementById('img_url').files[0];
			
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
					if(response != 'false'){
						// Define o nome temporario
						tempName = response;
						// Altera a src da imagem para exibir o arquivo temporario
						$("#user_image").attr("src", "/user/"+tempName+"/temp").addClass('hide');
						// Altera o value do input=hidden da imagem para o arquivo temporario
						$("#img_url").attr("value", tempName);
					}
				});
			} else {
				window.alert("Erro!");
			}

		});

		// Verifica se o botao ficará disabled
		$scope.saveDisabled = function(user){
			if(statusCheckPasswords && statusImage && user.permission_group_id && user.name && user.surname && user.dob && user.language){
				return false;
			}
			return true;
		};

		// Envia formulário
		$scope.submit = function(user){
			$("#user").submit();
		}
		
		// Clica no input=file quando a houver um click na imagem
		$scope.changeImage = function() {
			$("#image").click();
		};

		// Altera estilo do icone ṕara editar image de usuario
		$("#image_content").on('mouseover', function(){
			$("#change_image").removeClass("edit-default").addClass("edit-active");
		}).on('mouseleave', function(){
			$("#change_image").removeClass("edit-active").addClass("edit-default");
		});
	});
	</script>
@stop