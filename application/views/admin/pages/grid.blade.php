<div class="page-header clearfix">
	<h1 class="pull-left">Pages</h1>
	<div class="pull-right">
		<a href="{{URL::to('admin_pages/add')}}" class="btn success">Add Page</a>
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
							<h3><a href="{{URL::to('admin_pages/edit/'.$page->id)}}">{{$page->title}}</a></h3>
						</td>
						<td>
							<a class="btn danger delete" href="{{URL::to('admin_pages/delete/'.$page->id)}}">Delete</a>
						</td>
					</tr>
				@endforeach
			</table>
		@else
			<p>No pages have been added yet.</p>
		@endif
	</div>
</div>

