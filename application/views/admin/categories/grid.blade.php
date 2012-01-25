<div class="page-header clearfix">
	<h1 class="pull-left">Categories</h1>
	<div class="pull-right">
		<a href="{{URL::to('admin_cats/add')}}" class="btn success">Add Category</a>
	</div>
</div>
<div class="row">
	<div class="span12">
		@if (count($categories) > 0)
			<table class="table table-striped">
				<tr>
					<th>Name</th>
					<th>Description</th>
					<th>Active Bundles</th>
				</tr>
				@foreach ($categories as $cat)
					<tr>
						<td>
							<h3><a href="{{URL::to('admin_cats/edit/'.$cat->id)}}">{{$cat->title}}</a></h3>
						</td>
						<td>
							{{$cat->description}}
						</td>
						<td>
							<span class="total">{{HTML::link('admin_bundles?category='.$cat->id, Nav::cat_count($cat->id))}}</span>
						</td>
					</tr>
				@endforeach
			</table>
		@else
			<p>No categories was found matching your request.</p>
		@endif
	</div>
</div>

