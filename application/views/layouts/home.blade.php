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
				<h1>Laravel Bundles</h1>
				<p>This site is a Laravel community project that allows developers to easily share and discover bundles.</p>
			</div>

			{{$content}}
		</div>

		{{View::make('partials.footer')->with('categories', $categories)->render()}}

		{{Asset::scripts()}}
	</body>
</html>