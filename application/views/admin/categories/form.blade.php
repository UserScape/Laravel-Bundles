{{Bootstrap::header('Manage Category')}}
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
						<input required="required" class="xlarge" id="title" name="title" size="30" type="text" value="{{(Input::old('title') != null) ? Input::old('title') : $category->title}}">
					</div>
				</div><!-- /clearfix -->

				<div class="clearfix">
					<label for="Description">Description</label>
					<div class="input">
						<textarea class="xxlarge" id="description" name="description" rows="5">{{(Input::old('description') != null) ? Input::old('description') : $category->description}}</textarea>
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