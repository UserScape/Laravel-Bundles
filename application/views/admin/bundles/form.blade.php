{{Bootstrap::header('Manage Bundle')}}
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
					<label for="normalSelect">Provider</label>
					<div class="input">
						<select name="provider" id="normalSelect" disabled="disabled">
							<option value="github" selected="selected">GitHub</option>
						</select>
					</div>
				</div><!-- /clearfix -->

				<div class="bundle_extras">

					<div class="clearfix">
						<label for="xlInput">Clone URL</label>
						<div class="input">
							<input class="xlarge error" id="location" name="location" size="30" type="text" value="{{(Input::old('location') != null) ? Input::old('location') : $bundle->location}}">
						</div>
					</div><!-- /clearfix -->

					<div class="clearfix">
						<label for="title">Title</label>
						<div class="input">
							<input required="required" class="xlarge" id="title" name="title" size="30" type="text" value="{{(Input::old('title') != null) ? Input::old('title') : $bundle->title}}">
						</div>
					</div><!-- /clearfix -->

					<div class="clearfix">
						<label for="summary">Summary</label>
						<div class="input">
							<textarea required="required" class="xxlarge" id="summary" name="summary" rows="5">{{(Input::old('summary') != null) ? Input::old('summary') : $bundle->summary}}</textarea>
							<span class="help-block">
								The summary will be displayed in the bundle list.
							</span>
						</div>
					</div>

					<div class="clearfix">
						<label for="description">Description</label>
						<div class="input">
							<textarea required="required" class="xxlarge" id="description" name="description" rows="8">{{(Input::old('description') != null) ? Input::old('description') : $bundle->description}}</textarea>
							<span class="help-block">
								The description is used on the bundle details page.
							</span>
						</div>
					</div>

					<div class="clearfix">
						<label for="website">Website</label>
						<div class="input">
							<input class="xlarge" id="website" name="website" size="30" type="text" value="{{(Input::old('website') != null) ? Input::old('website') : $bundle->website}}">
						</div>
					</div><!-- /clearfix -->

					<div class="clearfix">
						<label for="category_id">Category</label>
						<div class="input">
							<?php
							$selected = (Input::old('category_id') != null) ? Input::old('category_id') : $bundle->category_id;
							?>
							{{Form::select('category_id', $categories, $selected, array('class' => 'mediumSelect', 'required' => 'required'))}}
						</div>
					</div>
					<div class="clearfix">
						<label for="tags">Tags</label>
						<div class="input">
							<ul id="tags" class="tagit" name="tags[]"></ul>
						</div>
					</div><!-- /clearfix -->

					<div class="clearfix">
						<label for="xlInput">Dependencies</label>
						<div class="input">
							<ul id="dependencies" class="tagit" name="dependencies[]"></ul>
						</div>
					</div><!-- /clearfix -->

					<div class="clearfix">
					<label for="active">Active</label>
					<div class="input">
						{{Form::select('active', array('y' => 'Yes', 'n' => 'No'), (Input::old('active') != null) ? Input::old('active') : $bundle->active, array('id' => 'active'))}}
					</div>
				</div><!-- /clearfix -->

					<div class="actions">
						<input type="submit" class="btn primary" value="Save">&nbsp;
						<button type="reset" class="btn">Cancel</button>
					</div>
				</div>

			</fieldset>
		{{Form::close()}}
	</div>
</div>