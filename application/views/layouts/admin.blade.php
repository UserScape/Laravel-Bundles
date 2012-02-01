
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Administration</title>
		{{Asset::styles()}}
	</head>
	<body id="{{URI::segment(1, 'home')}}" class="{{URI::segment(2, 'index')}}">

		<!-- Navigation -->
		<div class="navbar navbar-static">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="{{URL::to('admin')}}">Bundles Admin</a>
					<ul class="nav">
						<li class="{{Nav::active('admin')}}">
							<a href="{{URL::to('admin')}}"><i class="icon-home icon-white"></i> Home</a>
						</li>
						<li class="{{Nav::active('admin/bundles*')}}">
							<a href="{{URL::to('admin/bundles')}}"><i class="icon-white icon-book"></i> Bundles</a>
						</li>
						<li class="{{Nav::active('admin/users*')}}">
							<a href="{{URL::to('admin/users')}}"><i class="icon-white icon-user"></i> Users</a>
						</li>
						<li class="{{Nav::active('admin/pages*')}}">
							<a href="{{URL::to('admin/pages')}}"><i class="icon-white icon-file"></i> Pages</a>
						</li>
						<li class="{{Nav::active('admin/cats*')}}">
							<a href="{{URL::to('admin/cats')}}"><i class="icon-white icon-list"></i> Categories</a>
						</li>
					</ul>
					<ul class="nav pull-right">
						<li>
							<a target="_blank" href="{{URL::to('/')}}" class="main-site">
								<i class="icon-white icon-plus"></i> Main Site
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Navigation -->

		<div class="container">
			<div class="messages">
				{{View::make('partials.messages')->render()}}
			</div>
			<div class="content">
				{{$content}}
			</div>
		</div> <!-- /container -->
		<footer>
			<div class="container">
				<div class="row">
					<div class="span3">
						<p>&copy; 2012 - UserScape
					</div>
					<div class="span3 offset6">
						<a href="http://userscape.com">{{HTML::image('img/createdbyuserscape-admin.png')}}</a>
					</div>
				</div>
			</div>
		</footer>
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
	</body>
</html>