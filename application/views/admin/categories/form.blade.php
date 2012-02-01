{{Bootstrap::header('Manage Category')}}
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
					{{Form::text('title', Form::value('title', $category), array('class' => 'span5', 'required' => 'required'))}}
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="uri">URI</label>
				<div class="controls">
					{{Form::text('uri', Form::value('uri', $category), array('class' => 'span5', 'required' => 'required'))}}
				</div>
			</div>

			<fieldset class="control-group">
				<label class="control-label" for="description">Description</label>
				<div class="controls">
					<textarea class="span6" id="description" name="description" rows="5">{{Form::value('description', $category)}}</textarea>
				</div>
			</fieldset>

			<div class="form-actions">
				{{Form::submit(__('form.save'))}}
				{{Form::reset(__('form.cancel'))}}
			</div>

		{{Form::close()}}
	</div>
</div>