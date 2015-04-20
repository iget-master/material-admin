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
                        </div>
                    </div>
                    <div class="body">
                        @include('materialadmin::panel.alerts')
                        {!! Form::open(array('route' => 'message.store', 'id' => 'new-message')) !!}
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
                            <div class="col-md-8">
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
                    <div class="footer">
                        <a href="/message" class="btn btn-flat">@lang('materialadmin::message.discard')</a>
                        <a id="save" role="submit" data-form="#new-message" class="btn btn-flat action" disabled>@lang('materialadmin::message.submit')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('title')
	@lang('materialadmin::message.create_title')
@stop

@section('toolbar')
	<a role="submit" data-form="#form_message" class="btn btn-round primary"><i class="md md-send"></i></a>
	<a href="/message" class="btn btn-round btn-sm warning"><i class="md md-arrow-back"></i></a>
@stop

@section('script')
    {!! HTML::script('js/app/message.js') !!}
@stop