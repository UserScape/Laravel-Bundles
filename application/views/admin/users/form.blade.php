{{Bootstrap::header('Manage User')}}
<div class="row">
	<div class="span14">

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

		{{Form::open()}}
			<fieldset>

				<div class="clearfix">
					<label for="username">Username</label>
					<div class="input">
						<input required="required" class="xlarge" id="username" name="username" size="30" type="text" value="{{(Input::old('username') != null) ? Input::old('username') : $user->username}}">
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="name">Name</label>
					<div class="input">
						<input required="required" class="xlarge" id="name" name="name" size="30" type="text" value="{{(Input::old('name') != null) ? Input::old('name') : $user->name}}">
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="email">Email</label>
					<div class="input">
						<input class="xlarge" id="email" name="email" size="30" type="text" value="{{(Input::old('email') != null) ? Input::old('email') : $user->email}}">
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="category_id">Group</label>
					<div class="input">
						<?php
						$selected = (Input::old('group') != null) ? Input::old('group') : $user->group_id;
						?>
						{{Form::select('group', $groups, $selected, array('class' => 'mediumSelect', 'required' => 'required'))}}
					</div>
				</div>

				<div class="actions">
					<input type="submit" class="btn primary" value="Save">&nbsp;
					<button type="reset" class="btn">Cancel</button>
				</div>

			</fieldset>
		{{Form::close()}}
	</div>
</div>