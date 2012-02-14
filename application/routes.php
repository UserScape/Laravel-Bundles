<?php
/**
 * Application Routes
 */
Route::get('category/(:any)', 'category@detail');
Route::get('bundle/(:any)', 'bundle@detail');
Route::get('bundle/(:any)/edit', 'bundle@edit');
Route::post('bundle/(:any)/edit', 'bundle@edit');
Route::get('bundle/add', 'bundle@add');
Route::get('user/login', 'user@login');
Route::get('user/edit', 'user@edit');
Route::get('user/(:any)/bundles', 'user@bundles');
Route::get('user/(:any)/logout', 'user@logout');
Route::get('user/(:any)', 'user@index');
Route::get('page/(:any)', 'page@detail');
Route::get('admin', 'admin.home@index');
Route::get('page/(:any)', 'page@detail');

Route::controller(array(
	'home', 'bundle', 'bundles',
	'categories', 'category', 'page',
	'rss', 'search', 'user'
));

/**
 * Api
 *
 * Generates an array of the bundle information for artisan.
 *
 * @param string $item
 * @return array
 */
Route::get('api/(:any)', function($item)
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
Route::get('tags', function(){

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
Route::get('dependencies', function(){

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
Route::post('rate', function(){

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

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/**
 * Before Filter
 *
 * Used to set a "goto" session item so we know
 * where to redirect the user to.
 */
Route::filter('before', function()
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
Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

/**
 * Auth check for admin
 *
 * Performs the same auth as below but the user also must be in the
 * administrator user group.
 */
Route::filter('admin_auth', function()
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
Route::filter('auth', function()
{
	if ( ! Auth::check())
	{
		return Redirect::to('/user/login')
			->with('message', '<strong>Error!</strong> You must be logged in to access that page.')
			->with('message_class', 'error');
	}
});