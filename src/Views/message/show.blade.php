@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('content')
	@include('materialadmin::panel.alerts')
    <div id="card-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8 card">
                    <div class="header">
                        <div class="info">
                            <h1>@lang('materialadmin::message.new_message')</h1>
                        </div>
                        <div class="action">
                            {!! Form::open(array('method'=>'DELETE', 'route' => array('message.destroy', $message->id))) !!}
                                <button type="submit" class="btn btn-flat"><i class="md md-delete"></i></button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="body">
                        @include('materialadmin::panel.alerts')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group show-only">
                                    {!! Form::label('from_user', trans('materialadmin::message.from_user')) !!}
                                    {!! Form::text('from_user', $message->sender->name, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group show-only">
                                    {!! Form::label('subject', trans('materialadmin::message.subject')) !!}
                                    {!! Form::text('subject', $message->subject, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group show-only">
                                    {!! Form::label('message', trans('materialadmin::message.message')) !!}
                                    <p>{!! $message->message !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <a href="/message" class="btn btn-flat">@lang('materialadmin::message.close')</a>
                    </div>
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

@section('script')
    {!! HTML::script('js/app/message.js') !!}
@stop