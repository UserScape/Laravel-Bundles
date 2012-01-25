<!-- Navigation -->
<div class="navbar navbar-static">
	<div class="navbar-inner">
		<div class="container">
			<h3><a class="brand" href="#">Laravel Bundles</a></h3>
			<ul class="nav">
				<li class="{{Nav::active('/')}}"><a href="{{URL::to()}}">Home</a></li>
				<li class="vertical-divider"></li>
				<li class="{{Nav::active('bundle/add')}}"><a href="{{URL::to('bundle/add')}}">Add Bundle</a></li>
				<li class="vertical-divider"></li>
				<?php $pages = Nav::pages(); ?>
				@foreach ($pages as $page)
				<li class="{{Nav::active('page/'.$page->uri)}}"><a href="{{URL::to('page/'.$page->uri)}}">{{$page->title}}</a></li>
				<li class="vertical-divider"></li>
				@endforeach
			</ul>
			<form class="navbar-search" method="get" action="{{URL::to('search')}}">
				<input type="text" class="search-query pull-left" placeholder="Search Bundles" name="q" value="{{strip_tags(Input::get('q'))}}">
			</form>
			<ul class="nav pull-right">
				@if (Auth::check())
				<li class="dropdown menu {{Nav::active('user/*')}}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="{{URL::to('user/profile')}}">{{HTML::image(Gravatar::from_email(Auth::user()->email, 24), $user->username, array('width' => 24, 'height' => '24', 'class' => 'gravatar'))}} Hello {{Auth::user()->name}} <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="{{Nav::active('user/bundles')}}"><a href="{{URL::to('user/bundles')}}">Your Bundles</a></li>
						<li class="{{Nav::active('bundle/add')}}"><a href="{{URL::to('bundle/add')}}">Add Bundle</a></li>
						<li class="divider"></li>
						<li class="{{Nav::active('user/logout')}}"><a href="{{URL::to('user/logout')}}">Logout</a></li>
					</ul>
				</li>
				@else
				<li class="login">
					<a class="btn primary" href="{{URL::to('user/login')}}">Login With GitHub</a>
				</li>
				@endif
			</ul>
		</div>
	</div>
</div>
<!-- End Navigation -->