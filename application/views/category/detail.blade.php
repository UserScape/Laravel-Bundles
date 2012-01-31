<section id="bundles">
	<div class="page-header">
	@if (isset($tag))
		<h1>Bundles tagged: {{$tag->tag}}</h1>
	@elseif (isset($user))
		<h1>Bundles by {{$user->name}}</h1>
	@elseif (isset($term))
		<h1>Search results for "{{$term}}"</h1>
	@else
		<h1>{{$category->title}}</h1>
	@endif
	</div>

	{{View::make('partials.grid')->with('bundles', $bundles)->render()}}
</section>
