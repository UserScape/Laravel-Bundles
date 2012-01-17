<section id="bundles">
	@if (isset($tag))
		<h1>Bundles tagged: {{$tag->tag}}</h1>
	@else
		<h1>{{$category->title}}</h1>
	@endif

	{{View::make('partials.grid')->with('bundles', $bundles)->render()}}
</section>
