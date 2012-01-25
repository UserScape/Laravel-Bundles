@if (Session::get('message'))
	<div class="alert alert-{{Session::get('message_class', 'error')}}">
		<p>{{Session::get('message')}}</p>
	</div>
@endif

<div id="msg_box" class="hide alert-message">
	<p id="msg_text"></p>
</div>