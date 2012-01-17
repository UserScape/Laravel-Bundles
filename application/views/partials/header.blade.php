<!-- Navigation -->
<div class="topbar-wrapper" style="z-index: 5;">
	<div class="topbar" data-dropdown="dropdown">
		<div class="topbar-inner">
			<div class="container">
				<h3><a href="#">Laravel Bundles</a></h3>
				<ul class="nav">
					<li class="active"><a href="{{URL::to()}}">Home</a></li>
					<li><a href="{{URL::to('bundle/add')}}">Add Bundle</a></li>
					@if (Auth::check())
					<li><a href="{{URL::to('user/bundles')}}">Your Bundles</a></li>
					@endif
				</ul>
				<form class="pull-left" action="">
					<input type="text" placeholder="Search Bundles">
				</form>
				<ul class="secondary-nav">
					<li class="login">
						@if (Auth::check())
						<a class="" href="{{URL::to('user/profile')}}">Your Account</a>
						@else
						<a class="btn primary" href="<?php echo URL::to('user/login'); ?>">Login With GitHub</a>
						@endif
					</li>
				</ul>
			</div>
		</div><!-- /topbar-inner -->
	</div><!-- /topbar -->
</div>
<!-- End Navigation -->