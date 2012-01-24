<section id="add">

	<div class="page-header">
		<h1>Add Bundle</h1>
	</div>

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

			<fieldset class="control-group">
				<label class="control-label" for="normalSelect">Provider</label>
				<div class="controls">
					<select name="provider" id="normalSelect" disabled="disabled">
						<option value="github" selected="selected">GitHub</option>
					</select>
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="repo">Repo</label>
				<div class="controls">
					<!-- @todo - Add this to the db -->
					{{Form::select('repo', $repos, (Input::old('repo') != null) ? Input::old('repo') : $bundle->title, array('id' => 'repo'))}}
					<span id="ajax-loader">{{HTML::image('img/ui-anim_basic_16x16.gif', 'Loading...')}}</span>
				</div>
			</fieldset>

			<div class="alert-message block-message info">
				<p><strong>Note:</strong> Once you select your repo the details section will load</p>
			</div>

			<div class="bundle_extras">

				{{Form::field('text', 'location', 'Clone URL', array(Input::old('location', $bundle->location), array('required' => 'required')))}}

				{{Form::field('text', 'title', 'Title', array(Input::old('title', $bundle->title), array('required' => 'required')))}}

				<fieldset class="control-group">
					<label class="control-label" for="summary">Summary</label>
					<div class="controls">
						<textarea required="required" class="input-xlarge" id="summary" name="summary" rows="5">{{(Input::old('summary') != null) ? Input::old('summary') : $bundle->summary}}</textarea>
						<p class="help-block">
							The summary will be displayed in the bundle list.
						</p>
					</div>
				</fieldset>

				<fieldset class="control-group">
					<label class="control-label" for="description">Description</label>
					<div class="controls">
						<textarea required="required" class="input-xlarge" id="description" name="description" rows="8">{{(Input::old('description') != null) ? Input::old('description') : $bundle->description}}</textarea>
						<p class="help-block">
							The description is used on the bundle details page.
						</p>
					</div>
				</fieldset>

				<fieldset class="control-group">
					<label class="control-label" for="website">Website</label>
					<div class="controls">
						<input class="xlarge" required="required" id="website" name="website" type="text" value="{{(Input::old('website') != null) ? Input::old('website') : $bundle->website}}">
					</div>
				</fieldset>

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
			</div>
		{{Form::close()}}
</section>