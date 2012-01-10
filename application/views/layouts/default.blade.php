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
	<body>

		<div class="container">
			<h1 class="main"><a href="http://laravel.com/">Laravel Bundles</a></h1>
			<div class="row show-grid">
				<div class="span5">
					<h2>Sidebar</h2>
					<ul>
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
					</ul>
				</div>
				<div class="span11">
					<h1>Hello, world!</h1>
					<p>Vestibulum id ligula porta felis euismod semper. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
					<p><a class="btn primary large">Learn more &raquo;</a></p>
					{{$content}}
				</div>
			</div>
			<footer>
				<p>&copy; 2012 Laravel</p>
			</footer>
		</div>
		@yield('scripts')
	</body>
</html>