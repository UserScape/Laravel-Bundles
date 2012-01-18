<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Laravel Bundles</title>
		{{Asset::styles()}}
		<!-- fonts -->
		<link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="{{URL::to_asset('img/favicon.ico')}}">

	</head>
	<body id="{{URI::segment(1, 'home')}}" class="{{URI::segment(2, 'index')}}">

		{{View::make('partials.header')->render()}}

		<div class="container">

			<div class="row">
				<div class="span12">
					<div class="main">
						{{View::make('partials.messages')->render()}}
						{{$content}}
					</div>
				</div>
				<div class="span4">
					<div class="sidebar">
						<h2>Categories</h2>
						<ul>
						@foreach ($categories as $category)
							<li class="{{Nav::cat('category/'.$category->uri)}}"><a href="{{URL::to('category/'.$category->uri)}}">{{$category->title}}</a> ({{Nav::cat_count($category->id)}})</li>
						@endforeach
						</ul>
					</div>
				</div>
			</div>
			<footer>
				<p>&copy; 2012 Userscape</p>
			</footer>
		</div>

		<div id="modal-from-dom" class="modal hide fade">
			<div class="modal-header">
				<a href="#" class="close">&times;</a>
				<h3 class="title">Modal Heading</h3>
			</div>
			<div class="modal-body">
				<p>One fine body…</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn primary">Primary</a>
				<a href="#" class="btn secondary">Secondary</a>
			</div>
		</div>

<script>
var SITE_URL = "<?php echo URL::to(); ?>";
var BASE_URL = "<?php echo URL::base(); ?>";
@if (isset($tags) AND is_array($tags))
	var initialTags = [
		@foreach ($tags as $tag)
			"{{$tag}}",
		@endforeach
	];
@else
	var initialTags = [];
@endif

@if (isset($dependencies) AND is_array($dependencies))
	var initialDependenciesTags = [
		@foreach ($dependencies as $item)
			"{{$item}}",
		@endforeach
	];
@else
	var initialDependenciesTags = [];
@endif
</script>
		{{Asset::scripts()}}
		<script>$(function () { prettyPrint() })</script>
	</body>
</html>