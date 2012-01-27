<section id="add">

	<div class="page-header">
		<h1>{{Lang::line('form.add')->get()}}</h1>
	</div>

	@if (count($errors->messages) > 0)
		<div class="alert alert-error">
			<p>{{Lang::line('form.error')->get()}}</p>
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


			<fieldset class="control-group">
				<label class="control-label" for="normalSelect">{{Lang::line('form.provider')->get()}}</label>
				<div class="controls">
					<select name="provider" id="normalSelect" disabled="disabled">
						<option value="github" selected="selected">GitHub</option>
					</select>
				</div>
			</fieldset>

			<fieldset class="control-group">
				<label class="control-label" for="repo">{{Lang::line('form.repo')->get()}}</label>
				<div class="controls">
					<!-- @todo - Add this to the db -->
					{{Form::select('repo', $repos, (Input::old('repo') != null) ? Input::old('repo') : $bundle->title, array('id' => 'repo'))}}
					<span id="ajax-loader">{{HTML::image('img/ui-anim_basic_16x16.gif', 'Loading...')}}</span>
				</div>
			</fieldset>

			<div class="alert alert-info info">
				<strong>{{Lang::line('form.note')->get()}}</strong> {{Lang::line('form.note_txt')->get()}}
			</div>

			<div class="bundle_extras">

				{{Form::field('text', 'location', Lang::line('form.clone_url')->get(), array(Input::old('location', $bundle->location), array('required' => 'required')))}}

				{{Form::field('text', 'title', Lang::line('form.title')->get(), array(Input::old('title', $bundle->title), array('required' => 'required')))}}

				<fieldset class="control-group">
					<label class="control-label" for="summary">{{Lang::line('form.summary')->get()}}</label>
					<div class="controls">
						<textarea required="required" class="input-xlarge" id="summary" name="summary" rows="5">{{(Input::old('summary') != null) ? Input::old('summary') : $bundle->summary}}</textarea>
						<p class="help-block">{{Lang::line('form.summary_txt')->get()}}</p>
					</div>
				</fieldset>

				<fieldset class="control-group">
					<label class="control-label" for="description">{{Lang::line('form.description')->get()}}</label>
					<div class="controls">
						<textarea required="required" class="input-xlarge" id="description" name="description" rows="8">{{(Input::old('description') != null) ? Input::old('description') : $bundle->description}}</textarea>
						<p class="help-block">{{Lang::line('form.description_txt')->get()}}</p>
					</div>
				</fieldset>

				{{Form::field('text', 'website', Lang::line('form.website')->get(), array(Input::old('website', $bundle->website)))}}

				<fieldset class="control-group">
					<label class="control-label" for="category_id">{{Lang::line('form.category')->get()}}</label>
					<div class="controls">
						<?php $selected = (Input::old('category_id') != null) ? Input::old('category_id') : $bundle->category_id; ?>
						{{Form::select('category_id', $categories, $selected, array('id' => 'category_id', 'required' => 'required'))}}
					</div>
				</fieldset>

				<fieldset class="control-group">
					<label class="control-label" for="tags">{{Lang::line('form.tags')->get()}}</label>
					<div class="controls">
						<ul id="tags" class="tagit" name="tags[]"></ul>
					</div>
				</fieldset>

				<fieldset class="control-group">
					<label class="control-label" for="Dependencies">{{Lang::line('form.dependencies')->get()}}</label>
					<div class="controls">
						<ul id="dependencies" class="tagit" name="dependencies[]"></ul>
					</div>
				</fieldset>

				<fieldset class="control-group">
					<label class="control-label" for="active">{{Lang::line('form.active')->get()}}</label>
					<div class="controls">
						{{Form::select('active', array('y' => Lang::line('form.yes')->get(), 'n' => Lang::line('form.no')->get()), (Input::old('active') != null) ? Input::old('active') : $bundle->active, array('id' => 'active'))}}
					</div>
				</fieldset>

				{{Form::actions(array(Form::submit(Lang::line('form.save')->get(), array('class' => 'primary')), Form::reset(Lang::line('form.cancel')->get())))}}
			</div>
		{{Form::close()}}
</section>