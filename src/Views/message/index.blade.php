@extends((Request::ajax())?"materialadmin::layout.ajax":"materialadmin::layout.panel")

@section('title')
	@lang('materialadmin::message.title')
@stop

@section('content')
	<div id="messages-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				@include('materialadmin::panel.alerts')
				<?php $grouped_messages = $messages->groupBy(function ($a, $b) {
    return getFormatedDate($a->created_at);

}); ?>
				@foreach ($grouped_messages as $date => $messages)
					<?php
                        $diff = $messages[0]->created_at->startOfDay()->diffInDays();
                    ?>
					<div class="date">
					@if($diff == 0)
						<h5>@lang('materialadmin::message.today')</h5>
					@elseif($diff == 1)
						<h5>@lang('materialadmin::message.yesterday')</h5>
					@else 
						<h5>{!! $date !!}</h5>
					@endif
					<div class="card">
					@foreach ($messages as $message)
						<div class="message {!! ($message->read)?'read':'unread' !!}" data-id="{!! $message->id !!}" data-href="{!! route('message.show', $message->id) !!}">
							<div class="from">
								@if(is_null($message->sender))
								<img class="img-circle" src="/img/logo-round-40.png">
								<div class="img-placeholder {!! $message->sender->color !!}">
								{!! strtoupper(substr($message->sender->name, 0, 1)) !!}
								</div>
								@if(is_null($message->from_user_id))
									<span class="sender">@lang('materialadmin::message.system_message')</span>
								@else
									<span class="sender">{!! $message->sender->name !!} {!! $message->sender->surname !!}</span>
								@endif
							</div>
							<div class="content">
								<span class="subject">{!! $message->subject !!}</span> - <span class="text">{!! $message->message !!}</span>
							</div>
							<div class="actions">
								{!! Form::open(['method'=>'DELETE', 'route' => ['message.destroy', $message->id]]) !!}
                                    <button type="submit" class="btn btn-flat delete-index-item">
                                        <i class="zmdi zmdi-delete"></i>
                                    </button>
								{!! Form::close() !!}
                                @if ($message->read)
                                    <a href="{!! route('message.markunread', $message->id) !!}" class="btn btn-flat">
                                        <i class="zmdi zmdi-email"></i>
                                    </a>
                                @else
                                    <a href="{!! route('message.markread', $message->id) !!}" class="btn btn-flat">
                                        <i class="zmdi zmdi-email-open"></i>
                                    </a>
                                @endif

							</div>
						</div>
					@endforeach
					</div>
				@endforeach
				</div>
			</div>
		</div>
	</div>
@stop

@section('floating')
   <ul class="btn-action-group">
        <li class="primary">
            <span class="label">Compose Message</span>
            <a class="btn btn-floating" href="/message/create"><i class="zmdi zmdi-plus default"></i><i class="zmdi zmdi-comment-text hover"></i></a>
        </li>
    </ul>
@stop

@section('script')
    {!! HTML::script(versionedScriptUrl('iget-master/material-admin/js/app/message.js')) !!}
@stop