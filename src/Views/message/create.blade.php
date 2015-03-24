@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="content-wrapper">
			
	{!! Form::open(array('route' => 'message.store', 'id' => 'form_message')) !!}
		<div class="container">
			<div class="row">
				<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('to_user_id', 'Destino') !!}
					{!! Form::text('to_user_id', null, ['class'=>'form-control']) !!}
					@if ($errors->has('to_user_id'))
						{!! $errors->first('to_user_id') !!}	
					@endif
				</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
				<div class="form-group">
					{!! Form::label('subject','Assunto') !!}
					{!! Form::text('subject',null, ['class'=>'form-control']) !!}
					@if ($errors->has('subject'))
						{!! $errors->first('subject') !!}	
					@endif
				</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						{!! Form::label('message', 'Mensagem') !!}
						{!! Form::textarea('message', null, ['class'=>'form-control', 'rows'=>'5']) !!}
						@if ($errors->has('message'))
							{!! $errors->first('message') !!}
						@endif
					</div>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
	</div>
@stop

@section('title')
	Messages
@stop

@section('toolbar')
	<a role="submit" data-form="#form_message" class="btn btn-round primary"><i class="md md-check"></i></a>
	<a href="/message" class="btn btn-round btn-sm warning"><i class="md md-arrow-back"></i></a>
@stop