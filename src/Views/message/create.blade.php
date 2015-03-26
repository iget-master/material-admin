@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
	<div class="content-wrapper">
			
	{!! Form::open(array('route' => 'message.store', 'id' => 'form_message')) !!}
			<div class="row">
				<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('to_user_id', trans('materialadmin::message.to_user')) !!}
					{!! Form::select('to_user_id', IgetMaster\MaterialAdmin\Models\Message::getUsers(), null, ['class'=> 'form-control']) !!}
					@if ($errors->has('to_user_id'))
						{!! $errors->first('to_user_id') !!}	
					@endif
				</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
				<div class="form-group">
					{!! Form::label('subject', trans('materialadmin::message.subject')) !!}
					{!! Form::text('subject',null, ['class'=>'form-control']) !!}
					@if ($errors->has('subject'))
						{!! $errors->first('subject') !!}	
					@endif
				</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						{!! Form::label('message', trans('materialadmin::message.message')) !!}
						{!! Form::textarea('message', null, ['class'=>'form-control', 'rows'=>'5']) !!}
						@if ($errors->has('message'))
							{!! $errors->first('message') !!}
						@endif
					</div>
				</div>
			</div>
	{!! Form::close() !!}
	</div>
@stop

@section('title')
	@lang('materialadmin::message.create_title')
@stop

@section('toolbar')
	<a role="submit" data-form="#form_message" class="btn btn-round primary"><i class="md md-send"></i></a>
	<a href="/message" class="btn btn-round btn-sm warning"><i class="md md-arrow-back"></i></a>
@stop