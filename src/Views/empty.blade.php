@extends((Request::ajax())?"admin::layout.ajax":"admin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="content-wrapper">
	</div>
@stop

@section('title')
@stop

@section('toolbar')
@stop
