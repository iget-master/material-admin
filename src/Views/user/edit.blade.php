@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="content-wrapper">
			
	{!! Form::model($user, ['method'=>'PATCH', 'route'=>['user.update', $user->id], 'id'=>'user']) !!}
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('name', 'Nome:') !!}
						{!! Form::text('name', null, array('class' => 'form-control')) !!}
						@if ($errors->has('name'))
							{!! $errors->first('name') !!}	
						@endif
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('surname', 'Sobrenome:') !!}
						{!! Form::text('surname', null, array('class' => 'form-control')) !!}
						@if ($errors->has('surname'))
							{!! $errors->first('surname') !!}	
						@endif
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group">
						{!! Form::label('dob', 'Nascimento:') !!}
						{!! Form::text('dob', null, array('class' => 'form-control')) !!}
						@if ($errors->has('dob'))
							{!! $errors->first('dob') !!}	
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('email', 'Email:') !!}
						{!! Form::text('email', null, array('class' => 'form-control')) !!}
						@if ($errors->has('email'))
							{!! $errors->first('email') !!}	
						@endif
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						{!! Form::label('permission_group_id', 'Grupo de permissões:') !!}
						{!! Form::select('permission_group_id', $permission_groups, null, array('class' => 'form-control')) !!}
						@if ($errors->has('permission_group_id'))
							{!! $errors->first('permission_group_id') !!}	
						@endif
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						{!! Form::label('language', 'Língua padrão:') !!}
						{!! Form::select('language', IgetMaster\MaterialAdmin\Helper::getLanguagesSelectOptions(), null, array('class' => 'form-control')) !!}
						@if ($errors->has('language'))
							{!! $errors->first('language') !!}	
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="checkbox">
					    <label>
							<input type="checkbox" role="toggle" data-target="#password-container"> Alterar senha
					    </label>
					</div>
				</div>
			</div>
			<div id="password-container" class="hide">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							{!! Form::label('password', 'Senha:') !!}
							{!! Form::password('password', array('class' => 'form-control')) !!}
							@if ($errors->has('password'))
								{!! $errors->first('password') !!}	
							@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							{!! Form::label('password_confirmation', 'Confirme a senha:') !!}
							{!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
							@if ($errors->has('password_confirmation'))
								{!! $errors->first('password_confirmation') !!}	
							@endif
						</div>
					</div>
				</div>
			</div>				
		</div>
	{!! Form::close() !!}
	</div>
@stop

@section('title')
	Modificar usuário
@stop

@section('toolbar')
	<a role="submit" data-form="#user" class="btn btn-round primary"><i class="md md-check"></i></a>
	<a href="/user" class="btn btn-round btn-sm warning"><i class="md md-arrow-back"></i></a>
	{!! Form::open(array('method'=>'DELETE', 'route' => array('user.destroy', $user->id))) !!}
		<button type="submit" class="btn btn-round btn-sm danger"><i class="md md-delete"></i></button>
	{!! Form::close() !!}
@stop

@section('script')
	{!! HTML::script('js/app/users.js') !!}
@stop