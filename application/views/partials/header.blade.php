<!-- Navigation -->
<div class="topbar-wrapper" style="z-index: 5;">
	<div class="topbar" data-dropdown="dropdown">
		<div class="topbar-inner">
			<div class="container">
				<h3><a href="#">Laravel Bundles</a></h3>
				<ul class="nav">
					<li class="{{Nav::active('/')}}"><a href="{{URL::to()}}">Home</a></li>
					<li class="{{Nav::active('bundle/add')}}"><a href="{{URL::to('bundle/add')}}">Add Bundle</a></li>
					<?php $pages = Nav::pages(); ?>
					@foreach ($pages as $page)
					<li class="{{Nav::active('page/'.$page->uri)}}"><a href="{{URL::to('page/'.$page->uri)}}">{{$page->title}}</a></li>
					@endforeach
				</ul>
				<form method="get" class="pull-left" action="{{URL::to('search')}}">
					<input type="text" placeholder="Search Bundles" name="q" value="{{strip_tags(Input::get('q'))}}">
				</form>
				<ul class="nav secondary-nav">
					@if (Auth::check())
					<li class="menu {{Nav::active('user/*')}}">
						<a class="menu" href="{{URL::to('user/profile')}}">{{HTML::image(Gravatar::from_email(Auth::user()->email, 24), $user->username, array('width' => 24, 'height' => '24', 'class' => 'gravatar'))}} Hello {{Auth::user()->name}}</a>
						<ul class="menu-dropdown">
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
		</div><!-- /topbar-inner -->
	</div><!-- /topbar -->
</div>
<!-- End Navigation -->
<?php Nav::pages(); ?>