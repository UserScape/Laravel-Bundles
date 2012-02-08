<?php
/**
 * Application Routes
 */
Router::register('GET /category/(:any)', 'category@detail');
Router::register('GET /bundle/(:any)', 'bundle@detail');
Router::register('GET /bundle/(:any)/edit', 'bundle@edit');
Router::register('POST /bundle/(:any)/edit', 'bundle@edit');
Router::register('GET /bundle/add', 'bundle@add');
Router::register('GET /user/login', 'user@login');
Router::register('GET /user/edit', 'user@edit');
Router::register('GET /user/(:any)/bundles', 'user@bundles');
Router::register('GET /user/(:any)/logout', 'user@logout');
Router::register('GET /user/(:any)', 'user@index');
Router::register('GET /page/(:any)', 'page@detail');
Router::register('GET /admin', 'admin.home@index');

/**
 * Api
 *
 * Generates an array of the bundle information for artisan.
 *
 * @param string $item
 * @return array
 */
Router::register('GET /api/(:any)', function($item)
{
	$output = array();
	if ($bundle = Listing::where_uri($item)->first())
	{
		$dependencies = array();
		foreach ($bundle->dependencies AS $dependency)
		{
			$dependencies[] = $dependency->dependency_id;
		}

		$output = array(
			'status' => 'ok',
			'bundle' => array(
				'name' => $bundle->title,
				'provider' => $bundle->provider,
				'location' => $bundle->location,
				'path' => $bundle->path,
				'dependencies' => $dependencies
			)
		);

		// update the install log for record keeping.
		$install = new Install;
		$install->bundle_id = $bundle->id;
		$install->save();
	}
	else
	{
		$output = array('status' => 'not-found');
	}

	return json_encode($output);
});

/**
 * Tags List
 *
 * Generate a list of tags from an ajax call.
 */
Router::register('GET /tags', function(){

	$query = Tag::where('tag', 'like', '%'.Input::get('term').'%')->get();
	$tags = array();
	foreach ($query as $key => $tag)
	{
		$tags[] = $tag->tag;
	}
	return json_encode($tags);
});

/**
 * Dependencies
 *
 * Generate a list of dependencies from an ajax call.
 */
Router::register('GET /dependencies', function(){

	$query = Listing::where('title', 'like', '%'.Input::get('term').'%')->get();
	$tags = array();
	foreach ($query as $key => $tag)
	{
		$tags[] = $tag->title;
	}
	return json_encode($tags);
});

/**
 * Rating
 *
 * Rate a listing
 */
Router::register('POST /rate', function(){

	if ( ! Auth::check())
	{
		exit(json_encode(array('error' => 'You must be logged in')));
	}

	// Have we already rated?
	$rated = Rating::where('listing_id', '=', Input::get('id'))
		->where('user_id', '=', Auth::user()->id)
		->count();

	if ($rated == 0 and $listing = Listing::find(Input::get('id')))
	{
		// update the install log for record keeping.
		$rating = new Rating;
		$rating->listing_id = $listing->id;
		$rating->user_id = Auth::user()->id;
		$rating->ip_address = Request::ip();
		$rating->save();

		// Get the total ratings
		$vars['ratings'] = Rating::where_listing_id($listing->id)->count();
		$vars['success'] = 'true';
		exit(json_encode($vars));
	}
	return json_encode(array('error' => 'Could not save your rating.'));
});

/**
 * Before Filter
 *
 * Used to set a "goto" session item so we know
 * where to redirect the user to.
 */
Filter::register('before', function()
{
	$current_page = URI::current();

	// Set an array of ignored pages. This should ideally be switched to use
	// wildcard filtering.
	$ignored_pages = array(
		'user/login',
		'user/login/github',
		'user/edit',
		'favicon.ico'
	);

	// If it is not an ignored page then set a goto session.
	if ( ! Auth::check() AND ! in_array($current_page, $ignored_pages))
	{
		Session::put('goto', $current_page);
	}
	elseif (Auth::check() AND Session::has('goto'))
	{
		Session::forget('goto');
	}
});

/**
 * CSRF
 *
 * Check our tokens.
 */
Filter::register('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

/**
 * Auth check for admin
 *
 * Performs the same auth as below but the user also must be in the
 * administrator user group.
 */
Filter::register('admin_auth', function()
{
	if ( ! Auth::check() OR Auth::user()->group_id != 1)
	{
		return Redirect::to('/')
			->with('message', '<strong>Error!</strong> You must be an administrator to access that page.')
			->with('message_class', 'error');
	}
});

/**
 * Auth check
 *
 * Validates they are logged in.
 */
Filter::register('auth', function()
{
	if ( ! Auth::check())
	{
		return Redirect::to('/user/login')
			->with('message', '<strong>Error!</strong> You must be logged in to access that page.')
			->with('message_class', 'error');
	}
});