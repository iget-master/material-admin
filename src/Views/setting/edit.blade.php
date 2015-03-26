@extends((Request::ajax())?"materialadmin::setting.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="content-wrapper">
		@yield('form')
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