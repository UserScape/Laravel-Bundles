
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Administration</title>
		{{Asset::styles()}}
		<!-- fonts -->
		<link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
	</head>
	<body id="{{URI::segment(1, 'home')}}" class="{{URI::segment(2, 'index')}}">

		<!-- Navigation -->
		<div class="topbar">
			<div class="fill">
				<div class="container">
					<a class="brand" href="#">Project name</a>
					<ul class="nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#about">Bundles</a></li>
						<li><a href="#contact">Users</a></li>
						<li><a href="#contact">Categories</a></li>
						<li><a href="#contact">Tags</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Navigation -->

		<div class="container">

			<div class="content">
				{{View::make('partials.messages')->render()}}
				{{$content}}
			</div>

			<footer>
				<p>&copy; {{date("Y")}} Userscape</p>
			</footer>

		</div> <!-- /container -->

		{{Asset::scripts()}}
	</body>
</html>