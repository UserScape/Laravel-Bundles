{{Form::open(null, 'POST', array('class' => 'delete-cat'))}}
{{Form::hidden('id', $cat)}}
<div id="cat_model{{$cat}}" class="modal hide fade">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>Woah there sparky!</h3>
	</div>
	<div class="modal-body">
		<p>Are you sure you want to delete this?</p>
		<p>If so please select a category to move all the bundles too.</p>
		<?php if ($cat) unset($cat_select[$cat]); ?>
		{{Form::select('category', $cat_select, '', array('id' => 'cat_select'))}}
	</div>
	<div class="modal-footer">
		<input type="submit" class="btn danger" value="Yes Delete">
		<a href="#" class="btn" data-dismiss="modal">Get me outa here!</a>
	</div>
</div>
{{Form::close()}}