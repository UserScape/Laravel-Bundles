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

			{{Form::field('text', 'title', 'Title', array(Input::old('title', $category->title), array('class' => 'span6', 'required' => 'required')))}}

			<fieldset class="control-group">
				<label class="control-label" for="description">Description</label>
				<div class="controls">
					<textarea class="span6" id="description" name="description" rows="5">{{(Input::old('description') != null) ? Input::old('description') : $category->description}}</textarea>
				</div>
			</fieldset>

			{{Form::actions(array(Form::submit('Save', array('class' => 'primary')), Form::reset('Cancel')))}}

		{{Form::close()}}
	</div>
</div>