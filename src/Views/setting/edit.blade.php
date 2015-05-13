@extends((Request::ajax())?"materialadmin::setting.ajax":"materialadmin::layout.panel")

@section('title')
    <a href="{!! route('setting.index') !!}">@lang('materialadmin::settings.model_title')</a>
    <i class="md md-navigate-next"></i>
    @lang($setting['translation_key'])
@stop

@section('content')
    <div id="card-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8 card">
                    <div class="header">
                        <div class="info">
                            <h1>@lang($setting['translation_key'] . '_' . $action)</h1>
                        </div>
                        <div class="action">
                            @if ($action == 'edit')
                                {!! Form::open(array('method'=>'DELETE', 'route'=>['setting.update', $name, $model->id])) !!}
                                    <button type="submit" class="btn btn-flat" data-toggle="tooltip" data-placement="bottom" title="@lang($setting['delete_this'])"><i class="md md-delete"></i></button>
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                    @include('materialadmin::panel.alerts')
                    <div class="body">
                        @yield('form')
                    </div>
                    <div class="footer">
                        <a href="@yield('redirect_back_to', route('setting.index'))" class="btn btn-flat">@if($action = 'create') @lang('materialadmin::admin.action_cancel') @else @lang('materialadmin::admin.action_discard') @endif</a>
                        <a href="#" role="submit" data-form="#model" class="btn btn-flat action">@if($action = 'create') @lang('materialadmin::admin.action_create') @else @lang('materialadmin::admin.action_save') @endif</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
	{!! HTML::script('iget-master/material-admin/js/app/setting.js') !!}
@stop