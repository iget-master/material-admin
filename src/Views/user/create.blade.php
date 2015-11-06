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
								<i id="change_image" class="fa fa-pencil edit-default"></i>
							</div>
							@if (Request::old('image'))
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
										{!! Form::select('permission_group_id', $permission_groups, null, array('class' => 'form-control')) !!}
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										{!! Form::label('name', trans('materialadmin::user.name'), array('class' => 'required')) !!}
										{!! Form::text('name', null, array('class' => 'form-control')) !!}
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										{!! Form::label('surname', trans('materialadmin::user.surname'), array('class' => 'required')) !!}
										{!! Form::text('surname', null, array('class' => 'form-control')) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										{!! Form::label('dob', trans('materialadmin::user.dob')) !!}
										{!! Form::input('date', 'dob', null, array('class' => 'form-control')) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{!! Form::label('language', trans('materialadmin::user.default_language'), array('class' => 'required')) !!}
										{!! Form::select('language', IgetMaster\MaterialAdmin\Helper::getLanguagesSelectOptions(), null, array('class' => 'form-control')) !!}
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										{!! Form::label('email', trans('materialadmin::user.email'), array('class' => 'required')) !!}
										{!! Form::text('email', null, array('class' => 'form-control')) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 hidden">
									<div class="form-group">
										{!! Form::label('img_url', trans('materialadmin::user.img_url')) !!}
										{!! Form::file('img_url', ['id' => 'img_url', 'accept' => 'image/*']) !!}
									</div>
								</div>
								{!! Form::hidden('image', NULL, ['id' => 'image']) !!}
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										{!! Form::label('password', trans('materialadmin::user.password'), array('class' => 'required')) !!}
										{!! Form::password('password', array('class' => 'form-control')) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{!! Form::label('password_confirmation', trans('materialadmin::user.password_confirmation'), array('class' => 'required')) !!}
										{!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
									</div>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
					<div class="footer">
						<a href="/user" class="btn btn-flat">@lang('materialadmin::admin.action_cancel')</a>
						<a id="save" role="submit" data-form="#user" class="btn btn-flat action" disabled>@lang('materialadmin::admin.action_create')</a>
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

	angular.module("createView", []);
	angular.module("createView").controller("createViewController", function($scope, $http){
		// Define o nome de arquivo temporario para null
		var tempName = "";

		// Executa quando for selecionado alguma imagem no input=file
		$("#img_url").on('change', function(){
			// Pega a imagem selecionada
			var f = document.getElementById('img_url').files[0];
			
			// Se nenhum arquivo foi escolhido, sai da função.	
			if(typeof f == 'undefined') {
				return;
			}

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
				// Define o nome temporario
				tempName = response;
				// Altera a src da imagem para exibir o arquivo temporario
				$("#user_image").attr("src", "/user/"+tempName+"/temp").addClass('hide');
				// Altera o value do input=hidden da imagem para o arquivo temporario
				$("#image").attr("value", tempName);
			});
		});

		// Clica no input=file quando a houver um click na imagem
		$("#change_image").on("click", function(){
			$("#img_url").click();
		});

		// Altera estilo do icone ṕara editar image de usuario
		$("#image_content").on('mouseover', function(){
			$("#change_image").removeClass("edit-default").addClass("edit-active");
		}).on('mouseleave', function(){
			$("#change_image").removeClass("edit-active").addClass("edit-default");
		});
	});
	</script>
@stop