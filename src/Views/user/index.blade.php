@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="table-wrapper">
		<table id="users_table" class="index-table table table-condensed" >
			<thead>
				<th><input type="checkbox"></th>
				<th>ID</th>
				<th>@lang('materialadmin::user.name')</th>
				<th>@lang('materialadmin::user.email')</th>
				<th></th>
			</thead>
			<tbody>
			@foreach ($users as $user)
				<tr data-id="{!! $user->id !!}" data-delete-url="{!! route('user.destroy', [$user->id], false) !!}">
					<td><input type="checkbox"></td>
					<td>{!! $user->id !!}</td>
					<td>{!! $user->name !!}</td>
					<td>{!! $user->email !!}</td>
					<td class="actions">
						{!! link_to_route('user.edit', trans('materialadmin::user.edit'), [$user->id], ['role'=>'edit']) !!}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	{!! $users->render() !!}
@stop

@section('title')
	@lang('materialadmin::user.title')
@stop

@section('toolbar')
	<a href="/user/create" class="btn btn-round primary"><i class="md md-add"></i></a>
    {!! Form::open(array('method'=>'DELETE', 'id'=>'delete_items', 'route' => array('user.destroy'))) !!}
		<button type="submit" class="btn btn-round btn-sm btn-bulk danger"><i class="md md-delete"></i></button>
	{!! Form::close() !!}
@stop

@section('script')
	{!! HTML::script('packages/iget-master/materialadmin/js/app/users.js') !!}
@stop