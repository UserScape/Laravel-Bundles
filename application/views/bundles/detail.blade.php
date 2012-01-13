<h1>{{$bundle->title}}</h1>

<p>{{$bundle->description}}</p>

@if (count($bundle->dependencies) > 0)
<ul class="tags">
	<li class="first">Dependencies:</li>
	@foreach ($bundle->dependencies as $dependency)
		<li>{{HTML::link('bundle/detail/'.$dependency->uri, $dependency->title)}}</li>
	@endforeach
</ul>
@endif

@if (count($bundle->tags) > 0)
<ul class="tags">
	<li class="first">Tagged:</li>
	@foreach ($bundle->tags as $tag)
		<li>{{HTML::link('search/tag/'.$tag->uri, $tag->tag)}}</li>
	@endforeach
</ul>
@endif

