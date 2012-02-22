<section id="bundles">
	@if (isset($cat_title))
		<h1>{{$cat_title}}</h1>
	@elseif (isset($tag))
		<h1>Bundles tagged: {{$tag->tag}}</h1>
	@elseif (isset($user))
		<h1>Bundles by {{$user->name}}</h1>
	@elseif (isset($term))
		<h1>Search results for "{{$term}}"</h1>
	@elseif (isset($category))
		<h1>{{$category->title}} <a class="pull-right rss" href="{{URL::to('rss/category/'.$category->uri)}}">RSS</a></h1>
	@else
		<h1>All Bundles</h1>
	@endif

	{{View::make('partials.grid')->with('bundles', $bundles)->render()}}
</section>
