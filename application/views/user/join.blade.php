<section id="add">

	{{Bootstrap::header('Edit Account')}}

	<div class="alert alert-info info">
		<strong>Please Note:</strong> You need to enter your name and email address to register.
	</div>

	@if (count($errors->messages) > 0)
		<div class="alert alert-error">
			<p>{{__('form.error')}}</p>
			<ul>
			@foreach ($errors->all('<li>:message</li>') as $error)
				{{$error}}
			@endforeach
			</ul>
		</div>
	@endif

	{{Form::open(null, 'POST', array('class' => 'form-horizontal'))}}

		<fieldset>

			<div class="control-group">
				<label class="control-label" for="name">Name</label>
				<div class="controls">
					{{Form::text('name', Input::old('name', Auth::user()->name), array('class' => 'span5', 'required' => 'required'))}}
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="email">Email</label>
				<div class="controls">
					{{Form::text('email', Input::old('email', Auth::user()->email), array('class' => 'span5', 'required' => 'required'))}}
				</div>
			</div>

			<div class="form-actions">
				{{Form::submit(__('form.save'))}}
				{{Form::reset(__('form.cancel'))}}
			</div>

		</fieldset>
	{{Form::close()}}
</section>