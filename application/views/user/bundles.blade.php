<section id="bundles">
	@if (isset($user))
		<div class="page-header">
			<h1>Bundles by {{$user->name}} <a class="pull-right rss" href="{{URL::to('rss/user/'.$user->username)}}">RSS</a></h1>
		</div>
		{{View::make('partials.grid')->with('bundles', $bundles)->render()}}
	@else
		<div class="page-header">
			<h1>Error</h1>
		</div>
		<p>Sorry but we could not find that user</p>
	@endif
</section>
