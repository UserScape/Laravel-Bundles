<section id="bundles">
	@if (isset($user))
		<h1>Bundles by {{$user->name}}</h1>
		{{View::make('partials.grid')->with('bundles', $bundles)->render()}}
	@else
		<h1>Error</h1>
		<p>Sorry but we could not find that user</p>
	@endif
</section>
