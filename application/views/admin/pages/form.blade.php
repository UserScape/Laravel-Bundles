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

			<div class="control-group">
				<label class="control-label" for="title">Title</label>
				<div class="controls">
					{{Form::text('title', Form::value('title', $page), array('class' => 'span5', 'required' => 'required'))}}
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="uri">Uri</label>
				<div class="controls">
					{{Form::text('uri', Form::value('uri', $page), array('class' => 'span5', 'required' => 'required'))}}
				</div>
				<p class="help-block">The uri is what will be used to locate the page. If it is left blank it will be automatically created from the title</p>
			</div>

			<div class="control-group">
				<label class="control-label" for="content">Content</label>
				<div class="controls">
					<textarea required="required" class="span6" id="content" name="content" rows="8">{{Form::value('content', $page)}}</textarea>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="nav">Show in Nav</label>
				<div class="controls">
					<?php
						$selected = Form::value('nav', $page);
						$options = array('y' => 'Yes', 'n' => 'No');
					?>
					{{Form::select('nav', $options, $selected, array('class' => 'mediumSelect', 'required' => 'required'))}}
				</div>
			</div>

			<div class="form-actions">
				{{Form::submit(__('form.save'))}}
				{{Form::reset(__('form.cancel'))}}
			</div>

		{{Form::close()}}
	</div>
</div>