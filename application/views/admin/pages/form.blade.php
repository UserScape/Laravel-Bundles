{{Bootstrap::header('Manage Pages')}}
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
					<label for="title">Title</label>
					<div class="input">
						<input required="required" class="xlarge" id="title" name="title" size="30" type="text" value="{{(Input::old('title') != null) ? Input::old('title') : $page->title}}">
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="title">URI</label>
					<div class="input">
						<div class="input-prepend">
							<span class="add-on">{{URL::to()}}</span>
							<input class="medium" id="uri" name="uri" size="16" type="text" value="{{(Input::old('uri') != null) ? Input::old('uri') : $page->uri}}">
						</div>
						<span class="help-block">
							The uri is what will be used to locate the page. If it is left blank it will be automatically created from the title.
						</span>
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="content">Content</label>
					<div class="input">
						<textarea class="xxlarge" id="content" name="content" rows="20">{{(Input::old('content') != null) ? Input::old('content') : $page->content}}</textarea>
					</div>
				</div>

				<div class="clearfix">
					<label for="category_id">Parent</label>
					<div class="input">
						<?php
						$selected = (Input::old('parent') != null) ? Input::old('parent') : $page->parent;
						?>
						{{Form::select('parent', $parent_pages, $selected, array('class' => 'mediumSelect', 'required' => 'required'))}}
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