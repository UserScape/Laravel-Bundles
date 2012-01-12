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

	<div class="row">
		{{Form::open('bundle/add', 'POST')}}
			<fieldset>

				<div class="clearfix">
					<label for="normalSelect">Provider</label>
					<div class="input">
						<select name="provider" id="normalSelect" disabled="disabled">
							<option value="github" selected="selected">GitHub</option>
						</select>
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="xlInput">Clone URL</label>
					<div class="input">
						<input class="xlarge error" id="xlInput" name="location" size="30" type="text" value="{{Input::old('location')}}">
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="title">Title</label>
					<div class="input">
						<input class="xlarge" id="title" name="title" size="30" type="text" value="{{Input::old('title')}}">
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="summary">Summary</label>
					<div class="input">
						<textarea class="xxlarge" id="summary" name="summary" rows="5">{{Input::old('summary')}}</textarea>
						<span class="help-block">
							The summary will be displayed in the bundle list.
						</span>
					</div>
				</div>

				<div class="clearfix">
					<label for="description">Description</label>
					<div class="input">
						<textarea class="xxlarge" id="description" name="description" rows="8">{{Input::old('description')}}</textarea>
						<span class="help-block">
							The description is used on the bundle details page.
						</span>
					</div>
				</div>

				<div class="clearfix">
					<label for="website">Website</label>
					<div class="input">
						<input class="xlarge" id="website" name="website" size="30" type="text" value="{{Input::old('website')}}">
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="category">Category</label>
					<div class="input">
						{{Form::select('category', $categories, '', array('class' => 'mediumSelect'))}}
					</div>
				</div>
				<div class="clearfix">
					<label for="xlInput">Tags</label>
					<div class="input">
						<ul id="tags" class="tagit"></ul>
						<select class="tagit-hiddenSelect" name="tags" multiple="multiple"></select>
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="xlInput">Dependencies</label>
					<div class="input">
						<ul id="dependencies" class="tagit"></ul>
						<select class="tagit-hiddenSelect" name="dependencies" multiple="multiple"></select>
					</div>
				</div><!-- /clearfix -->

				<div class="actions">
					<input type="submit" class="btn primary" value="Next &raquo;">&nbsp;
					<button type="reset" class="btn">Cancel</button>
				</div>

			</fieldset>
		{{Form::close()}}
	</div>
</section>