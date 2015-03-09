@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	@foreach(\Config::get('admin.settings_groups') as $group)
	<div id="settings-group" class="paper clearfix">
		<div class="group-title">
			<i class="md md-lg {!! $group['icon'] !!}"></i>
			<h1>
				{!! trans($group['translation_key']) !!}
			</h1>
		</div>
		@foreach(\Config::get('admin.settings_items') as $item)
		<div id="settings-item">
			@include($item['item'])
		</div>
		@endforeach
	</div>
	@endforeach
@stop

@section('title')
	{!! trans('materialadmin::admin.settings') !!}
@stop

@section('toolbar')
	{{-- <a href="/user/create" class="btn btn-round primary"><i class="md md-add"></i></a>
    {!! Form::open(array('method'=>'DELETE', 'id'=>'delete_items', 'route' => array('user.multiple_destroy'))) !!}
		<button type="submit" class="btn btn-round btn-sm btn-bulk danger"><i class="md md-delete"></i></button>
	{!! Form::close() !!} --}}
@stop

@section('script')
	{!! HTML::script('packages/iget-master/materialadmin/js/app/settings.js') !!}
@stop