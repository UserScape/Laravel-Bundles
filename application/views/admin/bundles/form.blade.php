{{Bootstrap::header('Manage Bundle')}}
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

			{{Form::field('text', 'location', 'Clone URL', array(Input::old('location', $bundle->location), array('class' => 'span6', 'required' => 'required')))}}

			{{Form::field('text', 'title', 'Title', array(Input::old('title', $bundle->title), array('required' => 'required')))}}

			<fieldset class="control-group">
				<label class="control-label" for="summary">Summary</label>
				<div class="controls">
					<textarea required="required" class="span6" id="summary" name="summary" rows="5">{{(Input::old('summary') != null) ? Input::old('summary') : $bundle->summary}}</textarea>
					<p class="help-block">
						The summary will be displayed in the bundle list.
					</p>
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="description">Description</label>
				<div class="controls">
					<textarea required="required" class="span6" id="description" name="description" rows="8">{{(Input::old('description') != null) ? Input::old('description') : $bundle->description}}</textarea>
					<p class="help-block">
						The description is used on the bundle details page.
					</p>
				</div>
			</fieldset>

			{{Form::field('text', 'website', 'Website', array(Input::old('website', $bundle->website)))}}

			<fieldset class="control-group">
				<label class="control-label" for="category_id">Category</label>
				<div class="controls">
					<?php
						$selected = (Input::old('category_id') != null) ? Input::old('category_id') : $bundle->category_id;
						?>
					{{Form::select('category_id', $categories, $selected, array('id' => 'category_id', 'required' => 'required'))}}
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="tags">Tags</label>
				<div class="controls">
					<ul id="tags" class="tagit" name="tags[]"></ul>
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="Dependencies">Dependencies</label>
				<div class="controls">
					<ul id="dependencies" class="tagit" name="dependencies[]"></ul>
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="active">Active</label>
				<div class="controls">
					{{Form::select('active', array('y' => 'Yes', 'n' => 'No'), (Input::old('active') != null) ? Input::old('active') : $bundle->active, array('id' => 'active'))}}
				</div>
			</fieldset>

			{{Form::actions(array(Form::submit('Save', array('class' => 'primary')), Form::reset('Cancel')))}}

		{{Form::close()}}
	</div>
</div>