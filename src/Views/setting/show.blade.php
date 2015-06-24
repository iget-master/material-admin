@extends((Request::ajax())?"materialadmin::setting.ajax":"materialadmin::layout.panel")

@section('title')
    <a href="{!! route('setting.index') !!}">@lang('materialadmin::settings.model_title')</a>
    <i class="md md-navigate-next"></i>
    @lang($setting['translation_key'])
@stop

@section('content')
    @yield('form')
@stop

@section('toolbar')
	<a href="{{ route('setting.index') }}" class="btn btn-round btn-sm warning"><i class="md md-arrow-back"></i></a>
	@if (isset($model))
		{!! Form::open(array('method'=>'DELETE', 'route'=>['setting.update', $name, $model->id])) !!}
			<button type="submit" class="btn btn-round btn-sm danger"><i class="md md-delete"></i></button>
		{!! Form::close() !!}
	@endif
@stop

@section('script')
	{!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/app/setting.js')) !!}
@stop