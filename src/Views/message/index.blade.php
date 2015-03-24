@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="table-wrapper">
		<table id="users_table" class="index-table table table-condensed" >
			<thead>
				<th><input type="checkbox"></th>
				<th>Remetente</th>
				<th>Assunto</th>
				<th>Data</th>
			</thead>
			<tbody>
			@foreach ($messages as $message)
				<tr data-id="{!! $message->id !!}" data-delete-url="{!! route('user.destroy', [$message->id], false) !!}">
					<td><input type="checkbox"></td>
					@if(is_null($message->from_user_id))
						<td>Mensagem do Sistema</td>
					@else
						<td>{!! $message->from_user_id !!}</td>
					@endif
					<td>{!! $message->subject !!}</td>
					<td>{!! date('d/m/Y', strtotime($message->created_at)) !!}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{!! $messages->render() !!}
	</div>
@stop

@section('title')
	Messages
@stop

@section('toolbar')
	<a href="message/create" class="btn btn-round primary"><i class="md md-add"></i></a>
    {!! Form::open(array('method'=>'DELETE', 'id'=>'delete_items', 'route' => array('user.multiple_destroy'))) !!}
		<button type="submit" class="btn btn-round btn-sm btn-bulk danger"><i class="md md-delete"></i></button>
	{!! Form::close() !!}
@stop