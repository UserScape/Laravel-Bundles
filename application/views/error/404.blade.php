<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Error 404 - Not Found</title>
		<meta name="description" content="{{$description}}">

		<!-- styles -->
		<link href="http://laravel.com/css/style.css" rel="stylesheet" type="text/css">
		{{Asset::styles()}}

		<!-- Js for fonts and tracking -->
		<script type="text/javascript" src="http://use.typekit.com/dlj4kfm.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
		<script type="text/javascript" src="http://laravel.com/js/modernizr-2.5.2.min.js"></script>

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

		<div class="container main">
			<div class="row">
				<div class="content docs span12">
					<div class="well">

						<h1>404 Not Found</h1>

						<p>Sorry this page can not be found</p>

					</div>

				</div>
			</div>
		</div>
	</body>
</html>