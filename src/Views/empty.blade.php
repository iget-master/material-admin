@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="content-wrapper">
	</div>
@stop

@section('title')
	<span>Home</span>
@stop

@section('toolbar')
@stop
