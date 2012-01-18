<div class="row">
	<div class="span6">
		<h2><a href="#">Latest Bundles</a></h2>
		@if (count($latest) > 0)
			<table class="table zebra-striped">
			@foreach ($latest as $bundle)
				<tr>
					<td>
						<h3><a href="{{URL::to('bundle/detail/'.$bundle->uri)}}">{{$bundle->title}}</a></h3>
						<div class="summary">{{$bundle->summary}}</div>
					</td>
					<td><span class="label success">New</span></td>
				</tr>
			@endforeach
		</table>
		@endif
	</div>
	<div class="span5">
		<h2><a href="#">Categories</a></h2>
		<ul>
		@foreach ($categories as $category)
			<li><a href="{{URL::to('category/'.$category->uri)}}">{{$category->title}}</a> ({{Nav::cat_count($category->id)}})</li>
		@endforeach
		</ul>
	</div>
	<div class="span5">
		<h2><a href="#">Test</a></h2>
	</div>
</div>