<div class="page-header clearfix">
	<h1 class="pull-left">Pages</h1>
	<div class="pull-right">
		<a href="{{URL::to('admin/pages/add')}}" class="btn success">Add Page</a>
	</div>
</div>
<div class="row">
	<div class="span12">
		@if (count($pages) > 0)
			<table class="table table-striped">
				<tr>
					<th>Title</th>
					<th>Actions</th>
				</tr>
				@foreach ($pages as $page)
					<tr>
						<td>
							<h3><a href="{{URL::to('admin/pages/edit/'.$page->id)}}">{{$page->title}}</a></h3>
						</td>
						<td class="page-actions">
							<div class="btn-group">
								<a class="btn" href="#">Actions</a>
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a target="_blank" href="{{URL::to('page/'.$page->uri)}}" class=""><i class="zoom-in"></i> Preview</a></li>
									<li><a href="{{URL::to('admin/pages/edit/'.$page->id)}}"><i class="pencil"></i> Edit</a></li>
									<li class="divider"></li>
									<li class="remove">
										<a href="{{URL::to('admin/pages/delete/'.$page->id)}}" data-id="{{$page->id}}" class="delete">
											<i class="trash"></i> Delete
										</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
				@endforeach
			</table>
		@else
			<p>No pages have been added yet.</p>
		@endif
	</div>
</div>

