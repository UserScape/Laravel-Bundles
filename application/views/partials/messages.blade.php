@if (Session::get('message'))
	<div class="alert-message {{Session::get('message_class', 'error')}}">
		<p>{{Session::get('message')}}</p>
	</div>
@endif