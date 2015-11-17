@extends((Request::ajax())?"materialadmin::setting.ajax":"materialadmin::layout.panel")

@section('title')
    <a href="{!! route('setting.index') !!}">@lang('materialadmin::settings.model_title')</a>
    <i class="zmdi zmdi-chevron-right"></i>
    @lang($setting['translation_key'])
@stop

@section('content')
    @yield('form')
@stop

@section('toolbar')
	<a href="{{ route('setting.index') }}" class="btn btn-round btn-sm warning"><i class="zmdi zmdi-arrow-left"></i></a>
	@if (isset($model))
		{!! Form::open(array('method'=>'DELETE', 'route'=>['setting.update', $name, $model->id])) !!}
			<button type="submit" class="btn btn-round btn-sm danger"><i class="zmdi zmdi-delete"></i></button>
		{!! Form::close() !!}
	@endif
@stop

@section('script')
	{!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/app/setting.js')) !!}
@stop