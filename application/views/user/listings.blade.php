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
						<div class="btn-group">
							<a class="btn" href="#">Actions</a>
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="{{URL::to('bundle/detail/'.$bundle->uri)}}" class=""><i class="icon-zoom-in"></i> Preview</a></li>
								<li><a href="{{URL::to('bundle/edit/'.$bundle->id)}}"><i class="icon-pencil"></i> Edit</a></li>
								<li class="divider"></li>
								<li class="remove">
									<a href="{{URL::to('bundle/delete/'.$bundle->id)}}" data-id="{{$bundle->id}}" class="delete">
										<i class="icon-trash"></i> Delete
									</a>
								</li>
							</ul>
						</div>
					</td>
					<td class="">
						@if ($bundle->active == 'y')
							<span class="label label-success">Active</span>
						@else
							<span class="label label-notice">Not Active</span>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
		{{$bundles->links()}}
	@else
		<p>You haven't added any bundles yet.</p>
	@endif
</section>
