<footer>
	<div class="container">
		<div class="row">
			<div class="span4">
				<h3>Resources</h3>
				<ul class="footer unstyled resources">
					<li>{{HTML::link('http://laravel.com', 'Laravel Framework')}}</li>
					<li>{{HTML::link('http://laravel.com/docs', 'User Guide')}}</li>
					<li>{{HTML::link('http://forums.laravel.com', 'Community Forums')}}</li>
					<li>{{HTML::link('page/about', 'About this app')}}</li>
				</ul>
			</div>
			<div class="span4">
				<h3>Categories</h3>
				<div class="clearfix">
					<ul class="pull-left unstyled cats">
						@foreach ($categories as $key => $category)
							@if ($key <= 3)
							<li class="{{Nav::cat('category/'.$category->uri)}}">{{HTML::link('category/'.$category->uri, $category->title)}} ({{Nav::cat_count($category->id)}})</li>
							@endif
						@endforeach
					</ul>
					<ul class="pull-left unstyled cats">
						@foreach ($categories as $key => $category)
							@if ($key >= 4)
								<li class="{{Nav::cat('category/'.$category->uri)}}">{{HTML::link('category/'.$category->uri, $category->title)}} ({{Nav::cat_count($category->id)}})</li>
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

<div id="modal-from-dom" class="modal hide fade">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h3 class="title">Modal Heading</h3>
	</div>
	<div class="modal-body">
		<p>One fine body…</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
	</div>
</div>

<script>
var SITE_URL = "<?php echo URL::to(); ?>";
</script>
{{Asset::scripts()}}
<script>$(function(){prettyPrint()})</script>