<h1>{{$bundle->title}}</h1>

<p>{{$bundle->description}}</p>


@if (count($bundle->tags) > 0)
<ul class="tags">
	<li class="first">Tagged:</li>
	@foreach ($bundle->tags as $tag)
		<li>{{$tag->tag}}</li>
	@endforeach
</ul>
@endif