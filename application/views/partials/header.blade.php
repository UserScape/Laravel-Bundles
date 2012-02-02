<!-- Navigation -->
<div class="navbar navbar-static">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<h3><a class="brand" href="#">Laravel Bundles</a></h3>

			<div class="nav-collapse">
				<ul class="nav">
					<li class="{{Nav::active('/')}}">{{HTML::link('', 'Home')}}</li>
					<li class="vertical-divider"></li>
					<li class="{{Nav::active('bundle/add')}}">{{HTML::link('bundle/add', 'Add Bundle')}}</li>
					<li class="vertical-divider"></li>
					<?php $pages = Nav::pages(); ?>
					@foreach ($pages as $page)
						<li class="{{Nav::active('page/'.$page->uri)}}">{{HTML::link('page/'.$page->uri, $page->title)}}</li>
						<li class="vertical-divider"></li>
					@endforeach
				</ul>
				<form class="navbar-search pull-left" method="get" action="{{URL::to('search')}}">
					<input type="text" class="search-query span2" placeholder="Search Bundles" name="q" value="{{strip_tags(Input::get('q'))}}">
				</form>
				<ul class="nav pull-right">
					@if (Auth::check())
					<li class="dropdown menu {{Nav::active('user/*')}}">
						<a class="dropdown-toggle" data-toggle="dropdown" href="{{URL::to('user/'.Auth::user()->username)}}">{{HTML::image(Gravatar::from_email(Auth::user()->email, 24), $user->username, array('width' => 24, 'height' => '24', 'class' => 'gravatar'))}} Hello {{Auth::user()->name}} <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="{{Nav::active('user/'.Auth::user()->username)}}">{{HTML::link('user/'.Auth::user()->username, 'Your Bundles')}}</li>
							<li class="{{Nav::active('user/'.Auth::user()->username.'/*')}}">{{HTML::link('user/'.Auth::user()->username.'/bundles', 'Manage Bundles')}}</li>
							<li class="{{Nav::active('bundle/add')}}">{{HTML::link('bundle/add', 'Add Bundle')}}</li>
							<li class="divider"></li>
							<li class="{{Nav::active('user/logout')}}">{{HTML::link('user/'.Auth::user()->username.'/logout', 'Logout')}}</li>
						</ul>
					</li>
					@else
					<li class="login">{{HTML::link('user/login', 'Login with GitHub', array('class' => 'btn btn-small btn-primary'))}}</li>
					@endif
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- End Navigation -->
