@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div id="settings-groups">
		@foreach(\Config::get('admin.settings_groups') as $group)
		<div class="settings-group paper clearfix">
			<div class="group-title">
				<span>
					<i class="md md-lg {!! $group['icon'] !!}"></i>
					{!! trans($group['translation']['name']) !!}
				</span>
				<p class="help">
					{!! trans($group['translation']['help']) !!}
				</p>
			</div>
			@foreach(\Config::get('admin.settings_items') as $item_name => $item)
			<div class="settings-item" data-setting-name="{!! $item_name !!}" data-create="{!! route('setting.create', [$item_name]) !!}">
				@include($item['item'])
			</div>
			@endforeach
		</div>
		@endforeach
	</div>
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
	{!! HTML::script('iget-master/material-admin/js/app/setting.js') !!}

@stop