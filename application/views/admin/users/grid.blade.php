<div class="page-header clearfix">
	<h1 class="pull-left">Users</h1>
	<div class="filter pull-right">
		<form method="get" class="form-search" action="{{URL::to('admin_users')}}">
			Show Users in
			<?php $selected = Input::get('group') ?>
			{{Form::select('group', $groups, $selected, array('class' => 'smallSelect'))}}
			with
			<input type="text" placeholder="Keywords" name="q" value="{{strip_tags(Input::get('q'))}}">
			<input type="submit" class="btn small" value="Search">
		</form>
	</div>
</div>
<div class="row">
	<div class="span12">
		@if (count($users->results) > 0)
			<table class="table table-striped">
				<tr>
					<th>Name</th>
					<th>Username</th>
					<th>Email</th>
					<th>Group</th>
				</tr>
				@foreach ($users->results as $user)
					<tr>
						<td>
							{{HTML::image(Gravatar::from_email($user->email, 24), $user->username, array('width' => 24, 'height' => '24', 'class' => 'gravatar'))}}
							<h3><a href="{{URL::to('admin_users/edit/'.$user->id)}}">{{$user->name}}</a></h3>
						</td>
						<td>
							{{$user->username}}
						</td>
						<td>
							{{$user->email}}
						</td>
						<td>
							@if ($user->group_id == 1)
								<span class="label important">Administrator</span>
							@else
								<span class="label">Normal User</span>
							@endif
						</td>
					</tr>
				@endforeach
			</table>
			@if ($q = strip_tags(Input::get('q')))
				{{$users->appends(array('q' => $q))->links()}}
			@else
				{{$users->links()}}
			@endif
		@else
			<p>No users was found matching your request.</p>
		@endif
	</div>
</div>