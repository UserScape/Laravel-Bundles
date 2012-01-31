<section id="add">

	@if ($action == 'edit')
		{{Bootstrap::header(__('form.edit'))}}
	@else
		{{Bootstrap::header(__('form.add'))}}
	@endif

	@if (count($errors->messages) > 0)
		<div class="alert alert-error">
			<p>{{__('form.error')}}</p>
			<ul>
			@foreach ($errors->all('<li>:message</li>') as $error)
				{{$error}}
			@endforeach
			</ul>
		</div>
		{{Form::open(null, 'POST', array('class' => 'form-horizontal error'))}}
	@else
		{{Form::open(null, 'POST', array('class' => 'form-horizontal'))}}
	@endif
		<fieldset>

			<div class="control-group">
				{{Form::label('normalSelect', __('form.provider'), array('class' => 'control-label'))}}
				<div class="controls">
					<select name="provider" id="normalSelect" disabled="disabled">
						<option value="github" selected="selected">GitHub</option>
					</select>
				</div>
			</div>

			@if ($action != 'edit')
			<div class="control-group">
				<label class="control-label" for="repo">{{__('form.repo')}}</label>
				<div class="controls">
					<!-- @todo - Add this to the db -->
					{{Form::select('repo', $repos, (Input::old('repo') != null) ? Input::old('repo') : $bundle->title, array('id' => 'repo'))}}
					<span id="ajax-loader">{{HTML::image('img/ui-anim_basic_16x16.gif', 'Loading...')}}</span>
				</div>
			</div>
			@endif

			<div class="alert alert-info info">
				<strong>{{__('form.note')}}</strong> {{__('form.note_txt')}}
			</div>

			<div class="bundle_extras">

				{{Form::field('text', 'location', __('form.clone_url'), array(Input::old('location', $bundle->location), array('required' => 'required')))}}

				{{Form::field('text', 'title', __('form.title'), array(Input::old('title', $bundle->title), array('required' => 'required')))}}

				<div class="control-group">
					<label class="control-label" for="summary">{{__('form.summary')}}</label>
					<div class="controls">
						<textarea required="required" class="input-xlarge" id="summary" name="summary" rows="5">{{(Input::old('summary') != null) ? Input::old('summary') : $bundle->summary}}</textarea>
						<p class="help-block">{{__('form.summary_txt')}}</p>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="description">{{__('form.description')}}</label>
					<div class="controls">
						<textarea required="required" class="input-xlarge" id="description" name="description" rows="8">{{(Input::old('description') != null) ? Input::old('description') : $bundle->description}}</textarea>
						<p class="help-block">{{__('form.description_txt')}}</p>
					</div>
				</div>

				{{Form::field('text', 'website', __('form.website'), array(Input::old('website', $bundle->website)))}}

				<div class="control-group">
					<label class="control-label" for="category_id">{{__('form.category')}}</label>
					<div class="controls">
						<?php $selected = (Input::old('category_id') != null) ? Input::old('category_id') : $bundle->category_id; ?>
						{{Form::select('category_id', $categories, $selected, array('id' => 'category_id', 'required' => 'required'))}}
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="tags">{{__('form.tags')}}</label>
					<div class="controls">
						<ul id="tags" class="tagit" name="tags[]"></ul>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="Dependencies">{{__('form.dependencies')}}</label>
					<div class="controls">
						<ul id="dependencies" class="tagit" name="dependencies[]"></ul>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="active">{{__('form.active')}}</label>
					<div class="controls">
						{{Form::select('active', array('y' => __('form.yes'), 'n' => __('form.no')), (Input::old('active') != null) ? Input::old('active') : $bundle->active, array('id' => 'active'))}}
					</div>
				</div>

				{{Form::actions(array(Form::submit(__('form.save'), array('class' => 'primary')), Form::reset(__('form.cancel'))))}}
			</div>
		</fieldset>
	{{Form::close()}}
</section>