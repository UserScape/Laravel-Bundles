<section id="bundles">
	@if (isset($tag))
		<h1>Bundles tagged: {{$tag->tag}}</h1>
	@else
		<h1>{{$category->title}}</h1>
	@endif


	@if (count($bundles) > 0)
		<table>
			<tr>
				<th>#</th>
				<th>Title</th>
			</tr>
			@foreach ($bundles->results as $bundle)
				<tr>
					<td>{{$bundle->id}}</td>
					<td><a href="{{URL::to('bundle/detail/'.$bundle->uri)}}">{{$bundle->title}}</a></td>
				</tr>
			@endforeach
		</table>
		{{$bundles->links()}}
	@else
		<p>No bundles in this category yet. Why not create one?</p>
	@endif
</section>
