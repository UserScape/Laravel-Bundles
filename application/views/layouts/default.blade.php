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

		<div class="container main">
			<div class="row">
				<div class="sidebar span3 <?php echo (URI::segment(1) == 'bundle' and $bundle) ? 'bundle_detail' : ''; ?>">
					<form method="get" action="{{URL::to('search')}}">
						<input type="search" results="5" class="" placeholder="Search Bundles" name="q" value="{{strip_tags(Input::get('q'))}}">
					</form>
					<h3>Categories</h3>
					<ul>
					@foreach ($categories as $key => $category)
						<li class="{{Nav::cat('category/'.$category->uri)}}">{{HTML::link('category/'.$category->uri, $category->title)}} <span>({{Nav::cat_count($category->id)}})</span></li>
					@endforeach
						<li class="">{{HTML::link('bundles', 'All Bundles')}}</li>
					</ul>

					<div class="btns">
						@if ( ! Auth::check())
						<a class="btn" href="{{URL::to('user/login')}}"><i class="lock"></i> Login with GitHub</a>
						@endif
						<a class="btn" href="{{URL::to('bundle/add')}}"><i class="plus"></i> Submit a Bundle</a>
					</div>
				</div>
				<div class="content bundles span9">
					@if (URI::segment(1) == 'bundle' and $bundle)
						<div class="tabbable">
							<div class="bundle-tabs">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#readme" data-toggle="tab">Overview</a></li>
									<li><a href="#installation" data-toggle="tab">Installation</a></li>
									@if (count($bundle->dependencies) > 0)
									<li><a href="#bundle-dependencies" data-toggle="tab">Dependencies</a></li>
									@endif
									<li><a href="#stats" data-toggle="tab">Stats</a></li>
									@if (Auth::user()->id == $bundle->user_id OR Auth::user()->group_id == 1)
									<li><a href="{{URL::to('bundle/'.$bundle->uri.'/edit')}}">Edit</a></li>
									@endif
								</ul>
							</div>
					@endif
					<div class="well">
						{{View::make('partials.messages')->render()}}
						{{$content}}
					</div>
					@if (URI::segment(1) == 'bundle' and $bundle)
						</div>
					@endif
				</div>
			</div>
		</div>

		{{View::make('partials.footer')->render()}}

	</body>
</html>