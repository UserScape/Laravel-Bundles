<div class="page-header clearfix">
	<h1 class="pull-left">Bundles</h1>
	<div class="filter pull-right">
		<form method="get" action="{{URL::to('admin_bundles')}}">
			Show Bundles in
			<?php $selected = Input::get('category'); ?>
			{{Form::select('category', $categories, $selected, array('class' => 'smallSelect'))}}
			with
			<input type="text" placeholder="Keywords" name="q" value="{{strip_tags(Input::get('q'))}}">
			<input type="submit" class="btn small" value="Search">
		</form>
	</div>
</div>
<div class="row">
	<div class="span14">
		@if (count($bundles->results) > 0)
			<table class="table zebra-striped">
				@foreach ($bundles->results as $bundle)
					<tr class="status_{{$bundle->active}}">
						<td class="gravatar">
							{{HTML::image(Gravatar::from_email($bundle->user->email, 60), $bundle->user->username, array('width' => 60, 'height' => '60', 'class' => 'gravatar'))}}
						</td>
						<td>
							<h3><a href="{{URL::to('admin_bundles/edit/'.$bundle->id)}}">{{$bundle->title}}</a></h3>
							<div class="summary">{{$bundle->summary}}</div>
						</td>
						<td class="meta">
							<ul>
								<li><strong>User:</strong> {{HTML::link('admin_users/edit/'.$bundle->user->id, $bundle->user->name)}}</li>
								<li><strong>Created:</strong> {{date("M jS, Y", strtotime($bundle->created_at))}}</li>
								<li><strong>Updated:</strong> {{date("M jS, Y", strtotime($bundle->updated_at))}}</li>
							</ul>
						</td>
					</tr>
				@endforeach
			</table>
			@if ($q = strip_tags(Input::get('q')))
				{{$bundles->appends(array('q' => $q))->links()}}
			@else
				{{$bundles->links()}}
			@endif
		@else
			<p>No bundles was found matching your request.</p>
		@endif
	</div>
</div>

