
@if (count($bundles) > 0)
	<table class="table zebra-striped">
		@foreach ($bundles->results as $bundle)
			<tr>
				<td>
					<h3><a href="{{URL::to('bundle/detail/'.$bundle->uri)}}">{{$bundle->title}}</a></h3>
					<div class="summary">{{$bundle->summary}}</div>
				</td>
				<td class="meta">
					@if (strtotime($bundle->created_at) >= strtotime('-7 days'))
					<span class="label success">New</span>
					@endif
				</td>
			</tr>
		@endforeach
	</table>
	{{$bundles->links()}}
@else
	<p>No bundles in this category yet. Why not create one?</p>
@endif