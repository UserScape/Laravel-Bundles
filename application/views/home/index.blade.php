<div class="row">
	<div class="span6">
		<h2>Most Popular</h2>
		@if (count($popular) > 0)
			<table class="table zebra-striped">
			@foreach ($popular as $bundle)
				<tr>
					<td>
						<h3><a href="{{URL::to('bundle/detail/'.$bundle->uri)}}">{{$bundle->title}}</a></h3>
						<div class="summary">{{$bundle->summary}}</div>
					</td>
					<td>
						@if (strtotime($bundle->created_at) >= strtotime('-7 days'))
						<span class="label success">New</span>
						@elseif (strtotime($bundle->updated_at) >= strtotime('-7 days'))
						<span class="label notice">Updated</span>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
		@endif
	</div>
	<div class="span6">
		<h2>Recently Updated</h2>
		@if (count($latest) > 0)
			<table class="table zebra-striped">
			@foreach ($latest as $bundle)
				<tr>
					<td>
						<h3><a href="{{URL::to('bundle/detail/'.$bundle->uri)}}">{{$bundle->title}}</a></h3>
						<div class="summary">{{$bundle->summary}}</div>
					</td>
					<td>
						@if (strtotime($bundle->created_at) >= strtotime('-7 days'))
						<span class="label success">New</span>
						@elseif (strtotime($bundle->updated_at) >= strtotime('-7 days'))
						<span class="label notice">Updated</span>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
		@endif
	</div>
</div>