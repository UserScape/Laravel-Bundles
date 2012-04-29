<?php
/**
 * Bundles controller
 *
 * This is used for basic bundle crud operations as well as
 * displaying the bundle details page.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Bundle_Controller extends Base_Controller {

	/**
	 * Tell Laravel we want this class restful. See:
	 * http://laravel.com/docs/start/controllers#restful
	 *
	 * @param bool
	 */
	public $restful = true;

	/**
	 * Array of categories. Used in the forms.
	 *
	 * @param array
	 */
	protected $categories = array();

	/**
	 * Construct
	 *
	 * Pull out needed items and assign assets.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'auth')
			->only(array('add', 'edit'));

		// Get the categories
		$cats = Category::all();
		$this->categories[0] = __('form.please_select');
		foreach ($cats as $cat)
		{
			$this->categories[$cat->id] = $cat->title;
		}
	}

	/**
	 * Index
	 *
	 * Show all categories
	 */
	public function get_index()
	{
		return Redirect::to('/bundles');
	}

	/**
	 * Add a bundle
	 *
	 * Create the add bundle form which will send the posted
	 * data to the post_add method.
	 *
	 * @return string
	 */
	public function get_add()
	{
		return View::make('layouts.default')
			->with('title', 'Add Bundle')
			->nest('content', 'bundles.form', array(
				'categories' => $this->categories,
				'repos' => Github_helper::repos(),
				'action' => 'add'
			));
	}

	/**
	 * Get the repo data
	 *
	 * Uses the github api to pull in the repo info.
	 *
	 * @return string json
	 */
	public function post_repo()
	{
		$github = Github_helper::setup();
		$repo = Input::get('repo');
		$user = Input::get('user', Auth::user()->username);
		$vars = $github->getRepoApi()->show($user, $repo);
		$vars['readme'] = Github_helper::load_readme($user, $repo);

		// Strip out the url to generate the location
		$vars['url'] = Github_helper::location($vars['url']);

		return json_encode($vars);
	}

	/**
	 * Add a bundle
	 *
	 * This handles the posted data from the get_add method above.
	 *
	 * @return string view
	 */
	public function post_add()
	{
		Input::flash();
		$rules = array(
			'location'     => 'required',
			'title'        => 'required|max:200|unique:listings',
			'uri'          => 'required|alpha_dash|max:200|unique:listings',
			'summary'      => 'required',
			'description'  => 'required',
			'website'      => 'url',
			'provider'     => '',
			'category_id'  => 'required|numeric|min:1'
		);

		$messages = array(
			'min' => 'The :attribute field is required.',
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->invalid())
		{
			return Redirect::to('bundle/add')->with_errors($validator);
		}

		$uri = Input::get('uri');

		$listing = new Listing;
		$listing->title = Input::get('title');
		$listing->summary = strip_tags(Input::get('summary'));
		$listing->description = strip_tags(Input::get('description'));
		$listing->website = Input::get('website');
		$listing->location = Input::get('location');
		$listing->provider = Input::get('provider', 'github');
		$listing->category_id = Input::get('category_id', 1);
		$listing->active = Input::get('active', 'n');
		$listing->path = strtolower(Input::get('path', $title));
		$listing->user_id = Auth::user()->id;
		$listing->uri = $uri;
		$listing->save();

		// Now save tags
		$listing->save_tags($listing->id);

		// Now save dependencies
		$listing->save_dependencies($listing->id);

		// Finally get us out of here.
		return Redirect::to('bundle/detail/'.$uri);
	}

	/**
	 * Edit a bundle
	 *
	 * Create the edit bundle form which will send the posted
	 * data to the post_add method.
	 *
	 * @param int $id
	 * @return string view
	 */
	public function get_edit($id = 0)
	{
		// See if we can get the bundle
		if ( ! $bundle = Listing::where_uri($id)->first())
		{
			return Response::error('404');
		}

		if ($bundle->user_id != Auth::user()->id)
		{
			if (Auth::user()->group_id != 1)
			{
				return Response::error('404');
			}
		}

		// Get the associated tags.
		if (count($bundle->tags) > 0)
		{
			foreach ($bundle->tags as $key => $tag)
			{
				$tags[$key] = $tag->tag;
			}
		}

		// Get the dependencies and assign them to the layout for js.
		$dependencies = array();
		if (count($bundle->dependencies) > 0)
		{
			foreach ($bundle->dependencies as $key => $dependency)
			{
				$dependencies[$key] = $dependency->title;
			}
		}

		// Pass everything off to the view and assign it where it should go
		return View::make('layouts.default')
			->nest('content', 'bundles.form', array(
				'categories' => $this->categories,
				'bundle' => $bundle,
				'repos' => Github_helper::repos(),
				'action' => 'edit',
				'tags' => $tags,
				'dependencies' => $dependencies
			))
			->with('title', 'Edit Bundle');
	}

	/**
	 * Edit a bundle
	 *
	 * This handles the posted data from the get_edit method above.
	 *
	 * @param int $id
	 * @return string view
	 */
	public function post_edit($id = 0)
	{
		// Make sure we are valid.
		if ( ! $listing = Listing::where_uri($id)->first())
		{
			return Response::error('404');
		}

		$id = $listing->id;

		Input::flash();

		$rules = array(
			'location'     => 'required',
			'title'        => 'required|max:200|unique:listings,title,'.$listing->id,
			'uri'          => 'required|alpha_dash|max:200|unique:listings,uri,'.$listing->id,
			'summary'      => 'required',
			'description'  => 'required',
			'website'      => 'url',
			'provider'     => '',
			'category_id'  => 'required|numeric|min:1'
		);

		$messages = array(
			'min' => 'The :attribute field is required.',
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->invalid())
		{
			return Redirect::to('bundle/edit/'.$id)->with_errors($validator);
		}

		$title = Input::get('title');
		$uri = Input::get('uri');

		$listing->title = $title;
		$listing->summary = strip_tags(Input::get('summary'));
		$listing->description = strip_tags(Input::get('description'));
		$listing->website = Input::get('website');
		$listing->location = Input::get('location');
		$listing->provider = Input::get('provider', 'github');
		$listing->category_id = Input::get('category_id', 1);
		$listing->active = Input::get('active', 'n');
		$listing->path = strtolower(Input::get('path', $title));
		$listing->uri = $uri;
		$listing->save();

		// Now save tags
		$listing->save_tags($id);

		// Now save dependencies
		$listing->save_dependencies($id);

		return Redirect::to('bundle/'.$uri)
			->with('message', Lang::line('form.success')->get())
			->with('message_class', 'success');
	}

	/**
	 * Delete
	 *
	 * Delete a bundle
	 *
	 * @param int $id
	 * @return string json
	 */
	public function post_delete($id = 0)
	{
		$listing = Listing::find($id);
		if (Input::get('confirm') == 'true' and Auth::user()->id == $listing->user_id)
		{
			$listing->delete();

			// Delete all associations
			$tags = DB::table('listing_tags')->where('listing_id', '=', $id)->delete();
			$dependencies = DB::table('dependencies')->where('listing_id', '=', $id)->delete();
			$rating = DB::table('rating')->where('listing_id', '=', $id)->delete();
			$installs = DB::table('installs')->where('bundle_id', '=', $id)->delete();

			return json_encode(array('success' => true));
		}
		return json_encode(array('error' => true));
	}

	/**
	 * Bundle detail page
	 *
	 * @param string $item
	 * @return string view
	 */
	public function get_detail($item = '')
	{
		if ( ! $bundle = Listing::where_uri($item)->first())
		{
			return Response::error('404');
		}

		// This check is so the owner of the listing can
		// still preview the item when it isn't active.
		if ($bundle->active == 'n')
		{
			if (Auth::user()->id != $bundle->user_id)
			{
				return Response::error('404');
			}
		}

		// See if we can rate or have already rated
		$rating_class = 'notactive';
		if (Auth::check() AND $user = Auth::user()->id)
		{
			if ( ! Rating::where_user_id($user)->where('listing_id', '=', $bundle->id)->get())
			{
				$rating_class = 'alive';
			}
			else
			{
				$rating_class = 'rated';
			}
		}

		$bundle_array = explode('/', $bundle->location);
		$location = 'repos/'.$bundle_array[0].'/'.$bundle_array[1];

		$repo = Cache::remember('repos-'.$bundle_array[0].'-'.$bundle_array[1], function() use ($location)
		{
			return Github_helper::request($location);
		}, 90);

		// installs
		$installs = Install::where_bundle_id($bundle->id)->count();

		// Get the total ratings
		$ratings = Rating::where_listing_id($bundle->id)->count();

		return $this->layout->with('selected_cat', $bundle->category_id)
			->with('title', $bundle->title)
			->with('description', $bundle->summary)
			->with('bundle', $bundle)
			->nest('content', 'bundles.detail', array(
				'bundle'       => $bundle,
				'rating_class' => $rating_class,
				'ratings'      => $ratings,
				'installs'     => $installs,
				'repo'         => $repo,
			));
	}

	/**
	 * Get a bundle
	 *
	 * This is used via the ajax popover to show a dependency.
	 *
	 * @return string json
	 */
	public function post_ajax()
	{
		if ($listing = Listing::find(Input::get('id')))
		{
			$vars = array(
				'id' => $listing->id,
				'uri' => $listing->uri,
				'title' => $listing->title,
				'summary' => $listing->summary
			);
			exit(json_encode($vars));
		}
		exit(json_encode(array('error' => 'Could not load bundle.')));
	}
}