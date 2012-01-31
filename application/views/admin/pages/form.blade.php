{{Bootstrap::header('Manage Pages')}}
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

			{{Form::field('text', 'title', 'Title', array(Input::old('title', $page->title), array('class' => 'span6', 'required' => 'required')))}}

			{{Form::field('text', 'uri', 'URI', array(Input::old('uri', $page->uri), array('class' => 'span6'), array('help' => 'The uri is what will be used to locate the page. If it is left blank it will be automatically created from the title.')))}}

			<fieldset class="control-group">
				<label class="control-label" for="content">Content</label>
				<div class="controls">
					<textarea required="required" class="span6" id="content" name="content" rows="8">{{(Input::old('content') != null) ? Input::old('content') : $page->content}}</textarea>
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="nav">Show in Nav</label>
				<div class="controls">
					<?php
						$selected = (Input::old('nav') != null) ? Input::old('nav') : $page->nav;
						$options = array('y' => 'Yes', 'n' => 'No');
					?>
					{{Form::select('nav', $options, $selected, array('class' => 'mediumSelect', 'required' => 'required'))}}
				</div>
			</fieldset>

			{{Form::actions(array(Form::submit('Save', array('class' => 'primary')), Form::reset('Cancel')))}}

		{{Form::close()}}
	</div>
</div>