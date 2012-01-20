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
	<body id="{{URI::segment(1, 'home')}}" class="{{URI::segment(2, 'index')}}">

		{{View::make('partials.header')->render()}}

		<div class="container">

			<div class="hero-unit clearfix">
				<div class="pull-left">
					<h1>Laravel Bundles</h1>
					<p>This site is a Laravel community project that allows developers to easily share bundles with the community.</p>
				</div>
				<div class="pull-right">
					<h3>Categories</h3>
					<ul class="">
						@foreach ($categories as $category)
						<li class="{{Nav::cat('category/'.$category->uri)}}"><a href="{{URL::to('category/'.$category->uri)}}">{{$category->title}}</a> ({{Nav::cat_count($category->id)}})</li>
					@endforeach
					</ul>
				</div>
			</div>

			{{$content}}

			<footer>
				<ul class="footer unstyled">
					<li class="first">&copy; {{date("Y")}} <a href="http://userscape.com">UserScape, inc.</a></li>
				@foreach ($categories as $category)
					<li class="{{Nav::cat('category/'.$category->uri)}}"><a href="{{URL::to('category/'.$category->uri)}}">{{$category->title}}</a></li>
				@endforeach
				</ul>
			</footer>
		</div>
		{{Asset::scripts()}}
	</body>
</html>