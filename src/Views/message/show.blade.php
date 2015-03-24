@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="content-wrapper">
			
			<div class="row">
				<div class="col-md-4">
				<div class="form-group">
					<strong>
						@lang('materialadmin::message.sender')
					</strong>
					{!! Form::text('form_user', $message->sender->name, ['class'=>'form-control', 'disabled']) !!}
				</div>
				</div>
				<div class="col-md-3">
				<div class="form-group">
					<strong>
						@lang('materialadmin::message.date')
					</strong>
					{!! Form::text('form_user', date('d/m/Y', strtotime($message->created_at)), ['class'=>'form-control', 'disabled']) !!}
				</div>
				</div>
				<div class="col-md-3">
				<div class="form-group">
					<strong>
						@lang('materialadmin::message.time')
					</strong>
					{!! Form::text('form_user', date('G:i:s', strtotime($message->created_at)), ['class'=>'form-control', 'disabled']) !!}
				</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
				<div class="form-group">
					<strong>
						@lang('materialadmin::message.subject')
					</strong>
					{!! Form::text('subject', $message->subject, ['class'=>'form-control', 'disabled']) !!}
				</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<strong>
							@lang('materialadmin::message.message')
						</strong>
						{!! Form::textarea('message', $message->message, ['class'=>'form-control', 'rows'=>'5', 'disabled']) !!}
					</div>
				</div>
			</div>
	</div>
@stop

@section('title')
	@lang('materialadmin::message.show_title')
@stop

@section('toolbar')
	<a href="/message" class="btn btn-round primary warning"><i class="md md-arrow-back"></i></a>
	{!! Form::open(array('method'=>'DELETE', 'route' => array('message.destroy', $message->id))) !!}
		<button type="submit" class="btn btn-round btn-sm danger"><i class="md md-delete"></i></button>
	{!! Form::close() !!}
@stop