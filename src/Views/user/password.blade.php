@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('title')
<a href="/user" class="">@lang('materialadmin::user.title')</a>
<i class="zmdi zmdi-chevron-right"></i>
@lang('materialadmin::user.password_title')
@stop

@section('content')
<div id="card-wrapper" ng-app="user">
    <div class="container" ng-controller="passwordController">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 card">
                <div class="header">
                    <div class="col-md-12">
                        <div class="info">
                            <h6 class="helper">@lang('materialadmin::user.update_password_title')</h6>
                            <h1>{!! $user->name !!} {!! $user->surname !!}</h1>
                        </div>
                        <div class="action">
                        </div>
                    </div>
                </div>
                <div class="body">
                    @include('materialadmin::panel.alerts')
                    {!! Form::open(['method'=>'PATCH', 'route'=>['user.update_password', $user->id], 'id'=>'user']) !!}
                    <div id="password-container" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('password', trans('materialadmin::user.password'), array('class' => 'required')) !!}
                                {!! Form::password('password', array('class' => 'form-control', 'ng-model' => 'user.password', 'ng-change' => 'checkPasswords(user)')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('password_confirmation', trans('materialadmin::user.password_confirmation'), array('class' => 'required')) !!}
                                {!! Form::password('password_confirmation', array('class' => 'form-control', 'ng-model' => 'user.password_confirmation', 'ng-change' => 'checkPasswords(user)')) !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="footer">
                    <a id="save" class="btn btn-flat action" role="submit" data-form="#user" disabled>@lang('materialadmin::admin.action_save')</a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
{!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/app/users.js')) !!}
{!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/app/errors.js')) !!}

@if ($errors->any())
<script>
    $('form#user').formErrorParser({}, {!! $errors->toJson(); !!});
</script>
@endif
@stop
