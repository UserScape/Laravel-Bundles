<div class="row">
	<div class="span5">
		<h1>{{$bundle->title}}</h1>
		<button id="rate" data-id="{{$bundle->id}}" data-active="{{$rating_class}}" class="rating {{$rating_class}}"><span><i class="thumb-grey"></i> Thumbs Up</span></button>
	</div>
	<div class="span3">
		<fieldset>
			<legend>Details</legend>
			{{HTML::image(Gravatar::from_email($bundle->user->email, 54), $bundle->user->username, array('width' => 54, 'height' => '54', 'class' => 'gravatar'))}}
			<ul class="unstyled">
				<li><strong>Author:</strong> {{HTML::link('user/'.$bundle->user->username, $bundle->user->name)}}</li>
				<li><strong>Added On:</strong> {{date("d.m.Y", strtotime($bundle->created_at))}}</li>
				@if ($bundle->website)
				<li><a href="{{$bundle->website}}">Bundle Website</a></li>
				@endif
			</ul>
		</fieldset>
	</div>
</div>

<div class="tab-content">
	<div class="tab-pane active" id="readme">
		{{Github_helper::markdown($bundle->description)}}

		@if (count($bundle->tags) > 0)
		<ul class="tags unstyled">
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

