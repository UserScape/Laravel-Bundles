<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Laravel Bundles</title>
		{{Asset::styles()}}
		<!-- fonts -->
		<link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Quattrocento&v2' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	</head>
	<body id="{{URI::segment(1)}}" class="{{URI::segment(2, 'index')}}">

		<!-- Navigation -->
		<div class="topbar-wrapper" style="z-index: 5;">
			<div class="topbar" data-dropdown="dropdown">
				<div class="topbar-inner">
					<div class="container">
						<h3><a href="#">Laravel Bundles</a></h3>
						<ul class="nav">
							<li class="active"><a href="{{URL::to()}}">Home</a></li>
							<li><a href="{{URL::to('bundle/add')}}">Add Bundle</a></li>
						</ul>
						<form class="pull-left" action="">
							<input type="text" placeholder="Search">
						</form>
						<ul class="secondary-nav">
							<li class="login">
								@if (Auth::check())
								You are logged in
								@else
								<a class="btn primary" href="<?php echo URL::to('user/login'); ?>">Login With GitHub</a>
								@endif
							</li>
						</ul>
					</div>
				</div><!-- /topbar-inner -->
			</div><!-- /topbar -->
		</div>
		<!-- End Navigation -->

		<div class="container">
			<h1 class="main"><a href="http://laravel.com/">Laravel Bundles</a></h1>
			<div class="row show-grid">
				<div class="span5">
					<h2>Categories</h2>
					<ul>
					@foreach ($categories as $category)
						<li><a href="{{URL::to('category/'.$category->uri)}}">{{$category->title}}</a></li>
					@endforeach
					</ul>
				</div>
				<div class="span11">
					{{$content}}
				</div>
			</div>
			<footer>
				<p>&copy; 2012 Laravel</p>
			</footer>
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