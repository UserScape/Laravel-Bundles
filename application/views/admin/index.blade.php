{{Bootstrap::header('Dashboard')}}
<div class="row">

	<div class="span12">
		<div class="tabbable tabs-top">
			<ul id="tab" class="nav nav-tabs">
				<li class="active"><a href="#new" data-toggle="tab"><i class="icon inbox"></i> New Bundles</a></li>
				<li><a href="#updated" data-toggle="tab"><i class="icon edit"></i> Recently Updated</a></li>
				<li><a href="#new_users" data-toggle="tab"><i class="icon user"></i> New Users</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="new">
					<h2>New Bundles</h2>
					@if (count($new) > 0)
						<table class="table zebra-striped">
						@foreach ($new as $bundle)
							<tr>
								<td>
									<h3><a href="{{URL::to('admin/bundles/edit/'.$bundle->id)}}">{{$bundle->title}}</a></h3>
									<div class="summary">{{$bundle->summary}}</div>
								</td>
								<td>
									{{View::make('partials.admin-actions')->with('bundle', $bundle)->render()}}
								</td>
							</tr>
						@endforeach
					</table>
					@endif
				</div>
				<div class="tab-pane" id="updated">
					<h2>Updated Bundles</h2>
					@if (count($updated) > 0)
						<table class="table zebra-striped">
						@foreach ($updated as $bundle)
							<tr>
								<td>
									<h3><a href="{{URL::to('admin/bundles/edit/'.$bundle->id)}}">{{$bundle->title}}</a></h3>
									<div class="summary">{{$bundle->summary}}</div>
								</td>
								<td>
									{{View::make('partials.admin-actions')->with('bundle', $bundle)->render()}}
								</td>
							</tr>
						@endforeach
					</table>
					@endif
				</div>
				<div class="tab-pane" id="new_users">
					<h2>New Users</h2>
					@if (count($new_users) > 0)
						<table class="table zebra-striped">
						@foreach ($new_users as $user)
							<tr>
								<td>
									{{HTML::image(Gravatar::from_email($user->email, 24), $user->username, array('width' => 24, 'height' => '24', 'class' => 'gravatar'))}}
									<h3><a href="{{URL::to('admin/users/edit/'.$user->id)}}">{{$user->name}}</a></h3>
								</td>
								<td>
									{{$user->username}}
								</td>
								<td>
									{{$user->email}}
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

