{{Bootstrap::header('Manage User')}}
<div class="row">
	<div class="span12">

		@if (count($errors->messages) > 0)
			<div class="alert-message error">
				<p><strong>Houston!</strong> We have a problem.</p>
			</div>
			<ul>
				@foreach ($errors->all('<li>:message</li>') as $error)
					{{$error}}
				@endforeach
			</ul>
		@endif

		{{Form::open(null, 'POST', array('class' => 'form-horizontal'))}}

			<div class="control-group">
				<label class="control-label" for="username">Username</label>
				<div class="controls">
					{{Form::text('username', Form::value('username', $user), array('class' => 'span5', 'required' => 'required'))}}
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="name">Name</label>
				<div class="controls">
					{{Form::text('name', Form::value('name', $user), array('class' => 'span5', 'required' => 'required'))}}
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="name">Email</label>
				<div class="controls">
					{{Form::text('email', Form::value('email', $user), array('class' => 'span5', 'required' => 'required'))}}
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="category_id">Group</label>
				<div class="controls">
					<?php
						$selected = (Input::old('group') != null) ? Input::old('group') : $user->group_id;
					?>
					{{Form::select('group', $groups, $selected, array('class' => 'mediumSelect', 'required' => 'required'))}}
				</div>
			</div>

			<div class="form-actions">
				{{Form::submit(__('form.save'))}}
				{{Form::reset(__('form.cancel'))}}
			</div>

		{{Form::close()}}
	</div>
</div>