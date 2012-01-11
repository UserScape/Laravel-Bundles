<section id="add">
	<h1>{{$category->title}}</h1>

	@if (count($bundles) > 0)
		<table>
			<tr>
				<th>#</th>
				<th>Title</th>
			</tr>
			@foreach ($bundles as $bundle)
				<tr>
					<td>{{$bundle->id}}</td>
					<td><a href="{{URL::to('bundle/detail/'.$bundle->uri)}}">{{$bundle->title}}</a></td>
				</tr>
			@endforeach
		</table>
	@else
		<p>No bundles in this category yet. Why not create one?</p>
	@endif

</section>
