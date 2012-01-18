<h1>{{$bundle->title}}</h1>
<p class="meta">Added on {{date("D M jS, Y", strtotime($bundle->created_at))}} by {{HTML::link('search/user/'.$bundle->user->username, $bundle->user->name)}}</p>

<p>{{$bundle->description}}</p>

<div class="rating">
	<button id="rate" data-id="{{$bundle->id}}" data-active="{{$rating_class}}" class="btn info {{$rating_class}}"><span>Like</span></button> <span>{{$ratings}} likes</span>
</div>

<div class="installation">
	<h2>Installation</h2>
	<pre class="prettyprint bsh">php artisan bundle:install {{$bundle->uri}}</pre>
</div>

@if (count($bundle->dependencies) > 0)
<h2>Dependencies:</h2>
<ul>
	@foreach ($bundle->dependencies as $dependency)
		<li>{{HTML::link('bundle/detail/'.$dependency->uri, $dependency->title, array('rel' => 'dependency', 'data-original-title' => $dependency->title, 'data-content' => $dependency->summary))}}</li>
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