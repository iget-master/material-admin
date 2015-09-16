@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('title')
	<a href="/user" class="">@lang('materialadmin::user.title')</a>
	<i class="md md-navigate-next"></i>
	@lang('materialadmin::user.edit_title')
@stop

@section('content')
	<div id="card-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2 col-md-8 card">
					<div class="header">
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
					<div class="body">
						@include('materialadmin::panel.alerts')
						{!! Form::model($user, ['method'=>'PATCH', 'route'=>['user.update', $user->id], 'id'=>'user', 'files'=>true]) !!}
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
										{!! Form::input('date', 'dob', getFormatedDate($user->dob, true), array('class' => 'form-control')) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{!! Form::label('language', trans('materialadmin::user.default_language'), array('class' => 'required')) !!}
										{!! Form::select('language', IgetMaster\MaterialAdmin\Helper::getLanguagesSelectOptions(), null, array('class' => 'form-control')) !!}
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										{!! Form::label('email', trans('materialadmin::user.email'), array('class' => 'required')) !!}
										{!! Form::text('email', null, array('class' => 'form-control', 'disabled'=>'true')) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										{!! Form::label('img_url', trans('materialadmin::user.img_url')) !!}
										{!! Form::file('img_url') !!}
									</div>
								</div>
								@if(!is_null($user->img_url))
								<div class="col-md-6">
									<div class="form-group">
										<img class="img-circle" align="center" src="/user/{!! $user->id !!}/photo" alt="{!! $user->name !!}">
									</div>
								</div>
								@endif
							</div>
							<div class="row enable">
								<div class="col-md-12">
									<div class="form-group option">
										<input type="checkbox" name="enable-paid" role="enable" data-target="#password-container">
										<span class="text">@lang('materialadmin::user.change_password')</span>
									</div>
								</div>
							</div>
							<div id="password-container" class="row disabled">
								<div class="col-md-3">
									<div class="form-group">
										{!! Form::label('password', trans('materialadmin::user.password'), array('class' => 'required')) !!}
										{!! Form::password('password', array('class' => 'form-control')) !!}
										@if ($errors->has('password'))
											{!! $errors->first('password') !!}
										@endif
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{!! Form::label('password_confirmation', trans('materialadmin::user.password_confirmation'), array('class' => 'required')) !!}
										{!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
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
						<a id="save" role="submit" data-form="#user" class="btn btn-flat action" disabled>@lang('materialadmin::admin.action_save')</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('script')
	{!! HTML::script(versionedScriptUrl('js/app/users.js')) !!}
	{!! HTML::script(versionedScriptUrl('js/errors.js')) !!}

	@if ($errors->any())
		<script>
			$('form#user').formErrorParser({}, {!! $errors->toJson(); !!});
		</script>
	@endif
@stop