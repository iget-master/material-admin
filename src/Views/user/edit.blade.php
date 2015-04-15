@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('title')
	<a href="/user" class="">@lang('materialadmin::user.title')</a>
	<i class="md md-navigate-next"></i>
	@lang('materialadmin::user.edit_title')
@stop

@section('content')
{!! var_dump($errors->toArray()) !!}
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
								<button type="submit" class="btn btn-flat"><i class="md md-delete"></i></button>
							{!! Form::close() !!}
						</div>	
					</div>
					<div class="body">
						@include('materialadmin::panel.alerts')
						{!! Form::model($user, ['method'=>'PATCH', 'route'=>['user.update', $user->id], 'id'=>'user']) !!}
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
										{!! Form::text('dob', getFormatedDate($user->dob), array('class' => 'form-control')) !!}
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
								<div class="col-md-4">
									<div class="checkbox">
									    <label>
											<input type="checkbox" role="toggle" data-target="#password-container"> 
											@lang('materialadmin::user.change_password')
									    </label>
									</div>
								</div>
							</div>
							<div id="password-container" class="hide">
								<div class="row">
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
	{!! HTML::script('js/app/users.js') !!}
@stop