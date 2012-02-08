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
		{{Form::open(null, 'POST', array('class' => 'form-horizontal error '.$action))}}
	@else
		{{Form::open(null, 'POST', array('class' => 'form-horizontal '.$action))}}
	@endif
		{{Form::token()}}
		<fieldset>

			<!--
			<div class="control-group">
				{{Form::label('normalSelect', __('form.provider'), array('class' => 'control-label'))}}
				<div class="controls">
					<select name="provider" id="normalSelect" disabled="disabled">
						<option value="github" selected="selected">GitHub</option>
					</select>
				</div>
			</div>
			-->

			@if ($action != 'edit')
			<div class="control-group">
				<label class="control-label" for="repo">{{__('form.repo')}}</label>
				<div class="controls">
					<!-- @todo - Add this to the db -->
					{{Form::select('repo', $repos, Form::value('repo', $bundle), array('id' => 'repo'))}}
					<span id="ajax-loader">{{HTML::image('img/ui-anim_basic_16x16.gif', 'Loading...')}}</span>
				</div>
			</div>
			@endif

			<div class="alert alert-info info">
				<strong>{{__('form.note')}}</strong> {{__('form.note_txt')}}
			</div>

			<div class="bundle_extras">

				{{Form::hidden('location', Form::value('location', $bundle), array('class' => 'span5', 'required' => 'required'))}}

				<div class="control-group">
					<label class="control-label" for="title">{{__('form.title')}}</label>
					<div class="controls">
						{{Form::text('title', Form::value('title', $bundle), array('class' => 'span5', 'required' => 'required'))}}
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="summary">{{__('form.summary')}}</label>
					<div class="controls">
						<textarea required="required" class="input-xlarge" id="summary" name="summary" rows="5">{{Form::value('summary', $bundle)}}</textarea>
						<p class="help-block">{{__('form.summary_txt')}}</p>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="description">{{__('form.description')}}</label>
					<div class="controls">
						<textarea required="required" class="input-xlarge" id="description" name="description" rows="8">{{Form::value('description', $bundle)}}</textarea>
						<p class="help-block">{{__('form.description_txt')}}</p>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="path">Install Path</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on">bundles/</span>
							{{Form::text('path', Form::value('path', $bundle), array('class' => 'span5', 'id' => 'path'))}}
							<p class="help-block">The path where the bundle should be installed.</p>
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="title">{{__('form.website')}}</label>
					<div class="controls">
						{{Form::text('website', Form::value('website', $bundle), array('class' => 'span5'))}}
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="category_id">{{__('form.category')}}</label>
					<div class="controls">
						<?php $selected = Form::value('category_id', $bundle); ?>
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
						<?php $selected = Form::value('active', $bundle); ?>
						{{Form::select('active', array('y' => __('form.yes'), 'n' => __('form.no')), $selected, array('id' => 'active'))}}
					</div>
				</div>

				<div class="form-actions">
					{{Form::submit(__('form.save'))}}
					{{Form::reset(__('form.cancel'))}}
				</div>
			</div>
		</fieldset>
	{{Form::close()}}
</section>

<script>
@if (isset($tags) AND is_array($tags))
	var initialTags = [
		@foreach ($tags as $tag)
		"{{$tag}}",
		@endforeach
	];
@else
	var initialTags = [];
@endif

@if (isset($dependencies) AND is_array($dependencies))
	var initialDependenciesTags = [
	@foreach ($dependencies as $item)
		"{{$item}}",
	@endforeach
	];
@else
	var initialDependenciesTags = [];
@endif
</script>