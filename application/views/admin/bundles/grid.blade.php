<div class="page-header clearfix">
	<h1 class="pull-left">Bundles</h1>
	<div class="filter pull-right">
		<form method="get" class="form-search" action="{{URL::to('admin/bundles')}}">
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
	<div class="span12">
		@if (count($bundles->results) > 0)
			<table class="table table-striped">
				@foreach ($bundles->results as $bundle)
					<tr class="status_{{$bundle->active}}">
						<td>
							<h3><a href="{{URL::to('admin/bundles/edit/'.$bundle->id)}}">{{$bundle->title}}</a></h3>
							<div class="summary">{{Str::limit($bundle->summary, 100)}}</div>
						</td>
						<td class="user">
							{{HTML::image(Gravatar::from_email($bundle->user->email, 24), $bundle->user->username, array('width' => 24, 'height' => '24', 'class' => 'gravatar'))}}
							<div>{{HTML::link('admin/users/edit/'.$bundle->user->id, $bundle->user->name)}}</div>
						</td>
						<td>
							{{View::make('partials.admin-actions')->with('bundle', $bundle)->render()}}
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

