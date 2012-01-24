<footer>
	<div class="container clearfix">
		<div class="row">
			<div class="span4">
				<h3>Resources</h3>
				<ul class="footer unstyled resources">
					<li><a href="http://laravel.com">Laravel Framework</a></li>
					<li><a href="http://laravel.com">User Guide</a></li>
					<li><a href="http://forums.laravel.com/">Community Forums</a></li>
					<li><a href="{{URL::to('page/about')}}">About this app</a></li>
				</ul>
			</div>
			<div class="span4">
				<h3>Categories</h3>
				<div class="clearfix">
					<ul class="pull-left unstyled cats">
						@foreach ($categories as $key => $category)
							@if ($key <= 3)
							<li class="{{Nav::cat('category/'.$category->uri)}}"><a href="{{URL::to('category/'.$category->uri)}}">{{$category->title}}</a> ({{Nav::cat_count($category->id)}})</li>
							@endif
						@endforeach
					</ul>
					<ul class="pull-left unstyled cats">
						@foreach ($categories as $key => $category)
							@if ($key >= 4)
								<li class="{{Nav::cat('category/'.$category->uri)}}"><a href="{{URL::to('category/'.$category->uri)}}">{{$category->title}}</a> ({{Nav::cat_count($category->id)}})</li>
							@endif
						@endforeach
					</ul>
				</div>
			</div>
			<div class="span4">
				<a href="http://userscape.com">{{HTML::image('img/createdbyuserscape.png')}}</a>
			</div>
		</div>
	</div>
</footer>