<footer>
	<div class="container">
		<div class="row">
			<ul class="span7">
				<li><a href="<?php echo URL::to(); ?>">Home</a></li>
				<li><a href="#">About</a></li>
				<li><a href="http://forums.laravel.com">Forums</a></li>
				<li><a href="http://bundles.laravel.com">Bundles</a></li>
				<li><a href="#">Learn</a></li>
				<li class="download">
					<a href="http://laravel.com/download">Download <i class="download"></i></a>
				</li>
			</ul>
			<ul class="social span3 offset2">
				<li><a href="http://github.com/laravel"><i class="github"></i> GitHub</a></li>
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
<script>window.jQuery || document.write('<script src="http://localhost/laravel/laravel.com/public/js/jquery-1.7.1.min.js"><\/script>')</script>
<script src="http://localhost/laravel/laravel.com/public/js/bootstrap.js"></script>
<script src="http://localhost/laravel/laravel.com/public/js/main-min.js"></script>
{{Asset::scripts()}}
<script src="http://beta.laravel.com/js/google-code-prettify/prettify.js"></script>
<script>$(function(){prettyPrint()})</script>