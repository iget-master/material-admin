@extends((Request::ajax())?"materialadmin::setting.ajax":"materialadmin::layout.panel")

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
                                    <button type="submit" class="btn btn-flat"><i class="md md-delete"></i></button>
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                    @include('materialadmin::panel.alerts')
                    <div class="body">
                        @yield('form')
                    </div>
                    <div class="footer">
                        <a href="@yield('redirect_back_to', route('setting.index'))" class="btn btn-flat">@lang('materialadmin::setting.back')</a>
                        <a href="#" role="submit" data-form="#model" class="btn btn-flat action">@lang('materialadmin::setting.save')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('title')
	{!! trans($setting['translation_key']) !!}
@stop

@section('toolbar')
	<a role="submit" data-form="#model" class="btn btn-round primary"><i class="md md-check"></i></a>
	{{-- <a href="/user/create" class="btn btn-round primary"><i class="md md-add"></i></a> --}}
	<a href="@yield('redirect_back_to', route('setting.index'))" class="btn btn-round btn-sm warning"><i class="md md-arrow-back"></i></a>
	@if (isset($model))
		{!! Form::open(array('method'=>'DELETE', 'route'=>['setting.update', $name, $model->id])) !!}
			<button type="submit" class="btn btn-round btn-sm danger"><i class="md md-delete"></i></button>
		{!! Form::close() !!}
	@endif
@stop

@section('script')
	{!! HTML::script('iget-master/material-admin/js/app/setting.js') !!}
@stop