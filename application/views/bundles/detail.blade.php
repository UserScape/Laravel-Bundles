<div class="rating pull-right">
	<button id="rate" data-id="{{$bundle->id}}" data-active="{{$rating_class}}" class="btn {{$rating_class}}"><span>Thumbs Up</span></button>
</div>

<h1>{{$bundle->title}}</h1>

<p class="meta">Added on {{date("D M jS, Y", strtotime($bundle->created_at))}} by {{HTML::link('user/'.$bundle->user->username, $bundle->user->name)}}</p>

	<div id="myTabContent" class="tab-content">
		<div class="tab-pane active" id="readme">
			{{Github_helper::markdown($bundle->description)}}

			@if (count($bundle->tags) > 0)
			<ul class="tags">
				<li class="first">Tagged:</li>
				@foreach ($bundle->tags as $tag)
					<li>{{HTML::link('search/tag/'.$tag->tag, $tag->tag)}}</li>
				@endforeach
			</ul>
			@endif
		</div>
		<div class="tab-pane" id="installation">
			<h3>Installation</h3>
			<pre class="prettyprint bsh">php artisan bundle:install {{$bundle->uri}}</pre>
		</div>
		@if (count($bundle->dependencies) > 0)
		<div class="tab-pane" id="bundle-dependencies">
			<h3>Dependencies</h3>
			<ul>
				@foreach ($bundle->dependencies as $dependency)
					@if ($dependency->active == 'y')
						<li>{{HTML::link('bundle/detail/'.$dependency->uri, $dependency->title, array('rel' => 	'dependency', 'data-original-title' => $dependency->title, 'data-content' => $dependency->summary))}}</li>
					@endif
				@endforeach
			</ul>
		</div>
		@endif
		<div class="tab-pane" id="stats">
			<h3>Stats</h3>
			<ul>
				<li>{{$ratings}} likes</li>
				<li>{{$installs}} installs</li>
			</ul>
		</div>
	</div>

