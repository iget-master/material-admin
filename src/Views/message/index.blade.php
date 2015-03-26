@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="table-wrapper">
		<table id="messages-table" class="index-table table table-condensed" >
			<thead>
				<th><input type="checkbox"></th>
				<th>
					@lang('materialadmin::message.sender')
				</th>
				<th>
					@lang('materialadmin::message.subject')
				</th>
				<th>
					@lang('materialadmin::message.date')
				</th>
				<th></th>
			</thead>
			<tbody>
			@foreach ($messages as $message)
				
					<tr class='{!! ($message->read == 0)?'unread':null !!}' data-id="{!! $message->id !!}" data-delete-url="{!! route('message.destroy', [$message->id], false) !!}">

					<td><input type="checkbox"></td>
					@if(is_null($message->from_user_id))
						<td>Mensagem do Sistema</td>
					@else
						<td>{!! $message->sender->name !!}</td>
					@endif
					<td>{!! $message->subject !!}</td>
					<td>{!! date('d/m/Y', strtotime($message->created_at)) !!}</td>
					<td class="actions">{!! link_to_route('message.show', trans('materialadmin::message.open'), [$message->id], ['role'=>'edit']) !!}</td>
				</tr>

			@endforeach
			</tbody>
		</table>
		{!! $messages->render() !!}
	</div>
@stop

@section('title')
	@lang('materialadmin::message.title')
@stop

@section('toolbar')
	<a href="/message/create" class="btn btn-round primary"><i class="md md-send"></i></a>
    {!! Form::open(array('method'=>'DELETE', 'id'=>'delete_items', 'route' => ['message.multiple_destroy'])) !!}
		<button type="submit" class="btn btn-round btn-sm btn-bulk danger"><i class="md md-delete"></i></button>
	{!! Form::close() !!}
@stop