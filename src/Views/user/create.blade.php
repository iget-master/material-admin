@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="content-wrapper">
			
	{!! Form::open(array('route' => 'user.store', 'id' => 'user')) !!}
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('name', trans('materialadmin::user.name')) !!}
						{!! Form::text('name', null, array('class' => 'form-control')) !!}
						@if ($errors->has('name'))
							{!! $errors->first('name') !!}	
						@endif
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('surname', trans('materialadmin::user.surname')) !!}
						{!! Form::text('surname', null, array('class' => 'form-control')) !!}
						@if ($errors->has('surname'))
							{!! $errors->first('surname') !!}	
						@endif
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group">
						{!! Form::label('dob', trans('materialadmin::user.dob')) !!}
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
						{!! Form::label('email', trans('materialadmin::user.email')) !!}
						{!! Form::text('email', null, array('class' => 'form-control')) !!}
						@if ($errors->has('email'))
							{!! $errors->first('email') !!}	
						@endif
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						{!! Form::label('permission_group_id', trans('materialadmin::user.permission_group')) !!}
						{!! Form::select('permission_group_id', $permission_groups, null, array('class' => 'form-control')) !!}
						@if ($errors->has('permission_group_id'))
							{!! $errors->first('permission_group_id') !!}	
						@endif
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						{!! Form::label('language', trans('materialadmin::user.default_language')) !!}
						{!! Form::select('language', IgetMaster\MaterialAdmin\Helper::getLanguagesSelectOptions(), null, array('class' => 'form-control')) !!}
						@if ($errors->has('language'))
							{!! $errors->first('language') !!}	
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						{!! Form::label('password', trans('materialadmin::user.password')) !!}
						{!! Form::password('password', array('class' => 'form-control')) !!}
						@if ($errors->has('password'))
							{!! $errors->first('password') !!}	
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<div class="form-group">
						{!! Form::label('password_confirmation', trans('materialadmin::user.password_confirmation')) !!}
						{!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
						@if ($errors->has('password_confirmation'))
							{!! $errors->first('password_confirmation') !!}	
						@endif
					</div>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
	</div>
@stop

@section('title')
	@lang('materialadmin::user.create_title')
@stop

@section('toolbar')
	<a role="submit" data-form="#user" class="btn btn-round primary"><i class="md md-check"></i></a>
	<a href="/user" class="btn btn-round btn-sm warning"><i class="md md-arrow-back"></i></a>
@stop
@section('script')
	{!! HTML::script('js/app/users.js') !!}
@stop