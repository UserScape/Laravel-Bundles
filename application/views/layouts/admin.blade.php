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
		<div class="topbar-wrapper" style="z-index: 5;">
			<div class="topbar" data-dropdown="dropdown">
				<div class="topbar-inner">
					<div class="container">
						<h3><a href="#">Laravel Bundles</a></h3>
						<ul class="nav">
							<li class=""><a href="{{URL::to()}}">Home</a></li>
							<li class=""><a href="{{URL::to()}}">Users</a></li>
							<li class=""><a href="{{URL::to()}}">Bundles</a></li>
							<li class=""><a href="{{URL::to()}}">Categories</a></li>
							<li class=""><a href="{{URL::to()}}">Tags</a></li>
						</ul>
						<ul class="nav secondary-nav">
							<li class="menu {{Nav::active('user/*')}}">
								<a class="menu" href="{{URL::to('user/profile')}}">Hello {{Auth::user()->name}}</a>
								<ul class="menu-dropdown">
									<li class="{{Nav::active('user/bundles')}}"><a href="{{URL::to('user/bundles')}}">Your Bundles</a></li>
									<li><a href="#">Another Link</a></li>
									<li class="divider"></li>
									<li class="{{Nav::active('user/logout')}}"><a href="{{URL::to('user/logout')}}">Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div><!-- /topbar-inner -->
			</div><!-- /topbar -->
		</div>
		<!-- End Navigation -->

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
							<li><a href="#">Test</a></li>
						</ul>
					</div>
				</div>
			</div>
			<footer>
				<p>&copy; {{date('Y')}} Userscape</p>
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
		{{Asset::scripts()}}
	</body>
</html>