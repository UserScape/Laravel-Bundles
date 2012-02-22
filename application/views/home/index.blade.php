<div class="bundles-hero-unit">
	<div class="container">
		<div class="row">
			<div class="span5">
				<h1>Bundles</h1>
				<p>Where developers come to easily share and discover Laravel bundles</p>

				<div class="login-bar btns">
					@if ( ! Auth::check())
					<a class="btn" href="{{URL::to('user/login')}}"><i class="lock"></i> Login with GitHub</a>
					@else
					<a class="btn welcome" href="{{URL::to('user/'.Auth::user()->username)}}">{{HTML::image(Gravatar::from_email(Auth::user()->email, 32), Auth::user()->username, array('class' => 'gravatar'))}}Welcome, {{Auth::user()->name}}</a>
					@endif
					<a class="btn" href="{{URL::to('bundle/add')}}"><i class="plus"></i> Submit a Bundle</a>
				</div>

				<form method="get" class="search-form" action="{{URL::to('search')}}">
					<input type="search" style="span5" name="q" placeholder="Search Bundles">
				</form>
			</div>
			<div class="span7">
				<div class="featured-box">
					<h2>Featured Bundle: <span>{{$featured->title}}</span></h2>
					<img src="{{URL::to_asset('uploads/eloquent.png')}}">
					<p>Eloquent is a polite little ORM. It is named "Eloquent" because it allows you to work with your database objects and relationships using an eloquent and expressive syntax.</p>
					<a href="{{URL::to('bundle/'.$featured->uri);}}">Bundle Details</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="midcontent">
	<div class="container">

		<div class="boxes row">
			<div class="span6">
				<div class="popular-box">
					<h3>MOST POPULAR <small><a href="{{URL::to('bundles/popular')}}">View All</a></small></h3>
					@if (count($popular) > 0)
						<table class="table">
						@foreach ($popular as $bundle)
							<tr>
								<td>
									<h3><a href="{{URL::to('bundle/'.$bundle->uri)}}">{{$bundle->title}}</a></h3>
									<h4>Posted by <a href="{{URL::to('user/'.$bundle->username)}}">{{$bundle->name}}</a> On {{date("d.m.Y", strtotime($bundle->created_at))}}</h4>
									<div class="summary">{{$bundle->summary}}</div>
								</td>
							</tr>
						@endforeach
					</table>
					@endif
				</div>
			</div>
			<div class="span6">
				<div class="updated">
					<h3>RECENTLY UPDATED BUNDLES <small><a href="{{URL::to('bundles')}}">View All</a></small></h3>
					@if (count($latest) > 0)
						<table class="table zebra-striped">
						@foreach ($latest as $bundle)
							<tr>
								<td>
									<h3><a href="{{URL::to('bundle/'.$bundle->uri)}}">{{$bundle->title}}</a></h3>
									<h4>Posted by <a href="{{URL::to('user/'.$bundle->username)}}">{{$bundle->name}}</a> On {{date("d.m.Y", strtotime($bundle->created_at))}}</h4>
									<div class="summary">{{$bundle->summary}}</div>
								</td>
							</tr>
						@endforeach
					</table>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>