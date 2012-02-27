<footer>
	<div class="container">
		<div class="row">
			<ul class="span7">
				<li><a href="http://laravel.com">Home</a></li>
				<li><a href="http://laravel.com/about">About</a></li>
				<li><a href="http://forums.laravel.com">Forums</a></li>
				<li><a href="http://bundles.laravel.com">Bundles</a></li>
				<li><a href="http://laravel.com/docs">Learn</a></li>
				<li class="download">
					<a href="http://laravel.com/download">Download <i class="download"></i></a>
				</li>
			</ul>
			<div class="span2">
				<a class="sponsor" href="http://userscape.com">Sponsored by UserScape</a>
			</div>
			<ul class="social span3">
				<li><a href="https://github.com/UserScape/Laravel-Bundles"><i class="github"></i> Source Code</a></li>
				<li><a href="http://twitter.com/laravelphp"><i class="twitter"></i> Twitter</a></li>
			</ul>
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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="http://laravel.com/js/jquery-1.7.1.min.js"><\/script>')</script>
<script src="http://laravel.com/js/bootstrap.js"></script>
<script src="http://laravel.com/js/main-min.js"></script>
{{Asset::scripts()}}
<script src="http://laravel.com/js/google-code-prettify/prettify.js"></script>
<script>$(function(){prettyPrint()})</script>