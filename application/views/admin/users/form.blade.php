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

			{{Form::field('text', 'username', 'Username', array(Input::old('username', $user->username), array('class' => 'span6', 'required' => 'required')))}}

			{{Form::field('text', 'name', 'Name', array(Input::old('name', $user->name), array('class' => 'span6', 'required' => 'required')))}}

			{{Form::field('text', 'email', 'Email', array(Input::old('email', $user->email), array('class' => 'span6', 'required' => 'required')))}}

			<fieldset class="control-group">
				<label class="control-label" for="category_id">Group</label>
				<div class="controls">
					<?php
						$selected = (Input::old('group') != null) ? Input::old('group') : $user->group_id;
					?>
					{{Form::select('group', $groups, $selected, array('class' => 'mediumSelect', 'required' => 'required'))}}
				</div>
			</fieldset>

			{{Form::actions(array(Form::submit('Save', array('class' => 'primary')), Form::reset('Cancel')))}}

		{{Form::close()}}
	</div>
</div>