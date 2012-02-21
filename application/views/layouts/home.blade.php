<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>{{(isset($title) ? $title.' - ' : '')}}Laravel Bundles</title>
		<meta name="description" content="{{$description}}">
		<meta name="keywords" content="php framework, framework, restful routing, restful, clean php">
		<meta name="robots" content="index,follow">
		<meta name="application-name" content="Laravel">
		<link rel="author" href="humans.txt">
		<link rel="dns-prefetch" href="//ajax.googleapis.com">
		<link rel="shortcut icon" href="http://laravel.com/img/favicon.png">

		<!-- styles -->
		<link href="http://beta.laravel.com/css/style.css" rel="stylesheet" type="text/css">
		{{Asset::styles()}}

		<!-- Js for fonts and tracking -->
		<script type="text/javascript" src="http://use.typekit.com/dlj4kfm.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
		<script type="text/javascript" src="http://beta.laravel.com/js/modernizr-2.5.2.min.js"></script>

		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-23865777-1']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	</head>
	<body id="{{URI::segment(1, 'home')}}" class="{{URI::segment(2, 'index')}}">

		{{View::make('partials.header')->render()}}

		<div class="hero-unit">
			<div class="container">
				<h1>Bundles</h1>
				<p>Laravel is a clean and classy framework for PHP web development. Freeing you from
					spaghetti code, Laravel helps you<br> create wonderful applications using simple, expressive
					syntax. Development should be a creative experience<br> that you enjoy, not something that is
					painful. Enjoy the fresh air.</p>
			</div>
		</div>

		{{$content}}

		{{View::make('partials.footer')->with('categories', $categories)->render()}}

	</body>
</html>