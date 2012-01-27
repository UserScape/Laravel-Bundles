{{Bootstrap::header('Dashboard')}}
<div class="row">

	<div class="span12">
		<div class="tabbable tabs-top">
			<ul id="tab" class="nav tabs">
				<li class="active"><a href="#new" data-toggle="tab"><i class="icon inbox"></i> New Bundles</a></li>
				<li><a href="#updated" data-toggle="tab"><i class="icon refresh"></i> Recently Updated</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="new">
					<h2>New Bundles</h2>
					@if (count($new) > 0)
						<table class="table zebra-striped">
						@foreach ($new as $bundle)
							<tr>
								<td>
									<h3><a href="{{URL::to('admin_bundles/edit/'.$bundle->id)}}">{{$bundle->title}}</a></h3>
									<div class="summary">{{$bundle->summary}}</div>
								</td>
							</tr>
						@endforeach
					</table>
					@endif
				</div>
				<div class="tab-pane" id="updated">
					<h2>Updated Bundles</h2>
					@if (count($updated) > 0)
						<table class="table zebra-striped">
						@foreach ($updated as $bundle)
							<tr>
								<td>
									<h3><a href="{{URL::to('admin_bundles/edit/'.$bundle->id)}}">{{$bundle->title}}</a></h3>
									<div class="summary">{{$bundle->summary}}</div>
								</td>
							</tr>
						@endforeach
					</table>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
