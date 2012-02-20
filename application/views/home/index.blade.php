<div class="midcontent">
	<div class="container">

		<div class="boxes row">
			<div class="span6">
				<div class="documentation">
					<h3>MOST POPULAR</h3>
					@if (count($popular) > 0)
						<table class="table">
						@foreach ($popular as $bundle)
							<tr>
								<td>
									<h3><a href="{{URL::to('bundle/'.$bundle->uri)}}">{{$bundle->title}}</a></h3>
									<h4>Posted by <a href="{{URL::to('user/'.$bundle->username)}}">{{$bundle->name}}</a> On {{date("d.m.Y", strtotime($bundle->created_at))}}</h4>
									<div class="summary">{{$bundle->summary}}</div>
								</td>
							</tr>
						@endforeach
					</table>
					@endif
				</div>
			</div>
			<div class="span6">
				<div class="bundles">
					<h3>FEATURED</h3>
					@if (count($featured) > 0)
						<table class="table zebra-striped">
						@foreach ($featured as $bundle)
							<tr>
								<td>
									<h3><a href="{{URL::to('bundle/'.$bundle->uri)}}">{{$bundle->title}}</a></h3>
									<h4>Posted by <a href="{{URL::to('user/'.$bundle->username)}}">{{$bundle->name}}</a> On {{date("d.m.Y", strtotime($bundle->created_at))}}</h4>
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