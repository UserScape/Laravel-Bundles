<h1>{{$bundle->title}}</h1>

<p>{{$bundle->description}}</p>

<div class="installation">
	<h2>Installation</h2>
	<pre class="prettyprint bsh">php artisan bundle:install {{$bundle->uri}}</pre>
</div>

@if (count($bundle->dependencies) > 0)
<h2>Dependencies:</h2>
<ul>
	@foreach ($bundle->dependencies as $dependency)
		<li>{{HTML::link('bundle/detail/'.$dependency->uri, $dependency->title)}}</li>
	@endforeach
</ul>
@endif

@if (count($bundle->tags) > 0)
<ul class="tags">
	<li class="first">Tagged:</li>
	@foreach ($bundle->tags as $tag)
		<li>{{HTML::link('search/tag/'.$tag->tag, $tag->tag)}}</li>
	@endforeach
</ul>
@endif

