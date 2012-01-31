<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Error 404 - Not Found</title>
		<meta name="description" content="{{$description}}">
		{{Asset::styles()}}
		<!-- fonts -->
		<link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="{{URL::to_asset('img/favicon.ico')}}">

	</head>
	<body id="{{URI::segment(1, 'home')}}" class="{{URI::segment(2, 'index')}}">

		{{View::make('partials.header')->render()}}

		<div class="container">

			<div class="row">
				<div class="span8">
					<div class="main">
						{{Bootstrap::header('404 Error')}}

						<p>Sorry but this page is lost in an abyss of nothingness.</p>
					</div>
				</div>
				<div class="span4">
					<div class="well" style="padding: 8px 0;">
						<ul class="nav list">
							<li class="list-header">
								Categories
							</li>
						@foreach ($categories as $category)
							@if (isset($selected_cat) AND $selected_cat == $category->id)
							<li class="active"><a href="{{URL::to('category/'.$category->uri)}}">{{$category->title}}</a></li>
							@else
							<li class="{{Nav::cat('category/'.$category->uri)}}"><a href="{{URL::to('category/'.$category->uri)}}">{{$category->title}}</a>
							</li>
							@endif
						@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>

		{{View::make('partials.footer')->with('categories', $categories)->render()}}

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
	</body>
</html>