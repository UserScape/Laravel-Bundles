<div class="page-header clearfix">
	<h1>Categories</h1>
</div>
<div class="row">
	<div class="span14">
		@if (count($categories) > 0)
			<table class="table zebra-striped">
				<tr>
					<th>Name</th>
					<th>Active Bundles</th>
					<th>Description</th>
				</tr>
				@foreach ($categories as $cat)
					<tr>
						<td>
							<h3><a href="{{URL::to('admin_cats/edit/'.$cat->id)}}">{{$cat->title}}</a></h3>
						</td>
						<td>
							{{Nav::cat_count($cat->id)}}
						</td>
						<td>
							{{$cat->description}}
						</td>
					</tr>
				@endforeach
			</table>
		@else
			<p>No categories was found matching your request.</p>
		@endif
	</div>
</div>

