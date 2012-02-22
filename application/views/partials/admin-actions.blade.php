<div class="btn-group">
	<a class="btn" href="#">Actions</a>
	<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
	<ul class="dropdown-menu">
		<li><a target="_blank" href="{{URL::to('bundle/detail/'.$bundle->uri)}}" class=""><i class="icon-zoom-in"></i> Preview</a></li>
		<li><a href="{{URL::to('admin/bundles/edit/'.$bundle->id)}}"><i class="icon-pencil"></i> Edit</a></li>
		<li class="divider"></li>
		<li class="remove">
			<a href="{{URL::to('admin/bundles/delete/'.$bundle->id)}}" data-id="{{$bundle->id}}" class="delete">
				<i class="icon-trash"></i> Delete
			</a>
		</li>
	</ul>
</div>