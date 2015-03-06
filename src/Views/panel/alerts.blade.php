@if (Session::get('permission_denied'))
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		Ei! Você não possui permissão para acessar isso!
	</div>
@endif

@if (Session::get('messages'))
	@foreach(Session::get('messages')->getMessages() as $type=>$messages)
		@foreach($messages as $message)
			<div class="alert alert-{{$type}}">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{{$message}}
			</div>
		@endforeach
	@endforeach
@endif