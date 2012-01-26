@if (count($bundles->results) > 0)
	<table class="table zebra-striped">
		@foreach ($bundles->results as $bundle)
			<tr>
				<td class="gravatar">
					{{HTML::image(Gravatar::from_email($bundle->user->email, 60), $bundle->user->username, array('width' => 60, 'height' => '60', 'class' => 'gravatar'))}}
				</td>
				<td>
					<h3>{{HTML::link('bundle/detail/'.$bundle->uri, $bundle->title)}}</h3>
					<div class="summary">{{$bundle->summary}}</div>
				</td>
				<td class="meta">
					@if (strtotime($bundle->created_at) >= strtotime('-7 days'))
					<span class="label success">New</span>
					@elseif (strtotime($bundle->updated_at) >= strtotime('-7 days'))
					<span class="label notice">Updated</span>
					@endif
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