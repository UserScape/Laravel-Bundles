<section id="bundles">
	<h1>Your Bundles</h1>
	@if (count($bundles->results) > 0)
		<table class="table zebra-striped">
			@foreach ($bundles->results as $bundle)
				<tr class="status_{{$bundle->active}}">
					<td>
						<h3>{{$bundle->title}}</h3>
						<div class="summary">{{$bundle->summary}}</div>
					</td>
					<td>
						<a href="{{URL::to('bundle/edit/'.$bundle->id)}}" class="btn small primary">Edit</a>
						<a href="{{URL::to('bundle/detail/'.$bundle->uri)}}" class="btn small">Preview</a>
					</td>
					<td class="">
						@if ($bundle->active == 'y')
							<span class="label success">Active</span>
						@else
							<span class="label notice">Not Active</span>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
		{{$bundles->links()}}
	@else
		<p>You haven't added any listings yet.</p>
	@endif
</section>
