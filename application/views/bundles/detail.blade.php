<div class="rating pull-right">
	<button id="rate" data-id="{{$bundle->id}}" data-active="{{$rating_class}}" class="btn info {{$rating_class}}"><span>Like</span></button> <span>{{$ratings}} likes</span>
</div>

<h1>{{$bundle->title}}</h1>
<p class="meta">Added on {{date("D M jS, Y", strtotime($bundle->created_at))}} by {{HTML::link('search/user/'.$bundle->user->username, $bundle->user->name)}}</p>

<ul class="tabs" data-tabs="tabs">
	<li class="active"><a href="#readme">Readme</a></li>
	<li><a href="#installation">Installation</a></li>
	@if (count($bundle->dependencies) > 0)
	<li><a href="#bundle-dependencies">Dependencies</a></li>
	@endif
	<li><a href="#stats">Stats</a></li>
	@if (Auth::user()->id == $bundle->user_id)
	<li><a href="{{URL::to('bundle/edit/'.$bundle->id)}}">Edit</a></li>
	@endif
</ul>

<div id="my-tab-content" class="tab-content">
	<div class="tab-pane active" id="readme">
		{{Github_helper::markdown($bundle->description)}}
	</div>
	<div class="tab-pane installation" id="installation">
		<h2>Installation</h2>
		<pre class="prettyprint bsh">php artisan bundle:install {{$bundle->uri}}</pre>
	</div>
	@if (count($bundle->dependencies) > 0)
	<div class="tab-pane" id="bundle-dependencies">
		<h2>Dependencies</h2>
		<ul>
			@foreach ($bundle->dependencies as $dependency)
				@if ($dependency->active == 'y')
					<li>{{HTML::link('bundle/detail/'.$dependency->uri, $dependency->title, array('rel' => 'dependency', 'data-original-title' => $dependency->title, 'data-content' => $dependency->summary))}}</li>
				@endif
			@endforeach
		</ul>
	</div>
	@endif
	<div class="tab-pane stats" id="stats">
		<h2>Stats</h2>
		<ul>
			<li>{{$ratings}} likes</li>
			<li>{{$installs}} installs</li>
		</ul>
	</div>
</div>


@if (count($bundle->tags) > 0)
<ul class="tags">
	<li class="first">Tagged:</li>
	@foreach ($bundle->tags as $tag)
		<li>{{HTML::link('search/tag/'.$tag->tag, $tag->tag)}}</li>
	@endforeach
</ul>
@endif