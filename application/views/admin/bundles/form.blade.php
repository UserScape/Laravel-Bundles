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

			<div class="control-group">
				<label class="control-label" for="location">{{__('form.clone_url')}}</label>
				<div class="controls">
					{{Form::text('location', Form::value('location', $bundle), array('class' => 'span5', 'required' => 'required'))}}
				</div>
			</div>

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
					</div>
					<p class="help-block">The path where the bundle should be installed.</p>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="website">{{__('form.website')}}</label>
				<div class="controls">
					{{Form::text('website', Form::value('website', $bundle), array('class' => 'span5'))}}
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="class">Class</label>
				<div class="controls">
					{{Form::text('class', Form::value('class', $bundle), array('class' => 'span5'))}}
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

		{{Form::close()}}
	</div>
</div>