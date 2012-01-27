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
					<th>Active Bundles</th>
					<th>Actions</th>
				</tr>
				@foreach ($categories as $cat)
					<tr>
						<td>
							<h3><a href="{{URL::to('admin_cats/edit/'.$cat->id)}}">{{$cat->title}}</a></h3>
						</td>
						<td>
							<span class="total">{{HTML::link('admin_bundles?category='.$cat->id, Nav::cat_count($cat->id))}}</span>
						</td>
						<td>
							<div class="btn-group">
								<a class="btn" href="#">Actions</a>
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a target="_blank" href="{{URL::to('category/'.$cat->uri)}}" class=""><i class="zoom-in"></i> Preview</a></li>
									<li><a href="{{URL::to('admin_cats/edit/'.$cat->id)}}"><i class="pencil"></i> Edit</a></li>
									<li class="divider"></li>
									<li class="remove">
										<a href="#cat_model{{$cat->id}}" data-toggle="modal" data-id="{{$cat->id}}" class="cat_delete">
											<i class="trash"></i> Delete
										</a>
									</li>
								</ul>
							</div>
							{{View::make('partials.admin-cat_modal')->with('cat', $cat->id)->with('cat_select', $cat_select)->render()}}
						</td>
					</tr>
				@endforeach
			</table>
		@else
			<p>No categories was found matching your request.</p>
		@endif
	</div>
</div>