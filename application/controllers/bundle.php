<?php

class Bundle_Controller extends Controller {

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
	 */
	public function __construct()
	{
		Asset::add('jquery-tags', 'js/jquery.tagit.js', array('jquery','jquery-ui'));
		$this->filter('before', array('auth'))
			->only(array('add', 'edit'));

		// Get the categories
		$cats = Category::all();
		$this->categories[0] = 'Please Select';
		foreach ($cats as $cat)
		{
			$this->categories[$cat->id] = $cat->title;
		}
	}

	/**
	 * Setup GitHub
	 *
	 * Includes the api and sets up the repo list
	 */
	private function _setup_github()
	{
		require_once APP_PATH.'libraries/Github/Autoloader.php';
		Github_Autoloader::register();
		$this->github = new Github_Client();

		$this->repos = array();

		if ($all_repos = $this->github->getRepoApi()->getUserRepos(Auth::user()->username))
		{
			// format repos into a select list
			foreach ($all_repos as $repo)
			{
				$this->repos[$repo['name']] = $repo['name'];
			}
		}
		sort($this->repos);
		$this->repos[0] = 'Please Select';
	}

	/**
	 * Add a bundle
	 *
	 * Create the add bundle form which will send the posted
	 * data to the post_add method.
	 */
	public function get_add()
	{
		$this->_setup_github();
		return View::make('layouts.default')
			->nest('content', 'bundles.form', array(
				'categories' => $this->categories,
				'repos' => $this->repos,
			));
	}

	/**
	 * Get the repo data
	 *
	 * Uses the github api to pull in the repo info.
	 */
	public function post_repo()
	{
		$this->_setup_github();
		return json_encode($this->github->getRepoApi()->show(Auth::user()->username, Input::get('repo')));
	}

	/**
	 * Add a bundle
	 *
	 * This handles the posted data from the get_add method above.
	 *
	 */
	public function post_add()
	{
		Input::flash();
		$rules = array(
			'location'     => 'required|url',
			'title'        => 'required|max:200|unique:listings',
			'summary'      => 'required',
			'description'  => 'required',
			'website'      => 'url',
			'provider'     => '',
			'category_id'  => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('bundle/add')->with_errors($validator);
		}

		$title = Input::get('title');
		$uri = Str::slug($title, '-');

		$listing = new Listing;
		$listing->title = $title;
		$listing->summary = Input::get('summary');
		$listing->description = Input::get('description');
		$listing->website = Input::get('website');
		$listing->location = Input::get('location');
		$listing->provider = Input::get('provider', 'github');
		$listing->category_id = Input::get('category_id', 1);
		$listing->active = Input::get('active', 'n');
		$listing->user_id = 1; //@todo - Get user id from auth
		$listing->uri = $uri;
		$listing->save();

		// Now save tags
		$this->_save_tags($listing->id);

		// Now save dependencies
		$this->_save_dependencies($listing->id);

		// Finally get us out of here.
		return Redirect::to('bundle/detail/'.$uri);
	}

	/**
	 * Edit a bundle
	 *
	 * Create the edit bundle form which will send the posted
	 * data to the post_add method.
	 */
	public function get_edit($id = '')
	{
		// See if we can get the bundle
		if ( ! $bundle = Listing::find($id))
		{
			return Response::error('404');
		}

		$this->_setup_github();

		// Get the tags and assign them to the layout for js.
		$tag_query = Tag::where('tag', 'like', Input::get('term').'%')->get();
		$tags = array();
		foreach ($tag_query as $key => $tag)
		{
			$tags[$key] = $tag->tag;
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
				'repos' => $this->repos,
			))
			->with('tags', $tags)
			->with('dependencies', $dependencies);
	}

	/**
	 * Edit a bundle
	 *
	 * This handles the posted data from the get_edit method above.
	 *
	 * @param int $id
	 * @return void Redirects based on status.
	 */
	public function post_edit($id = '')
	{
		// Make sure we are valid.
		if ( ! is_numeric($id))
		{
			return Response::error('404');
		}

		Input::flash();

		$rules = array(
			'location'     => 'required|url',
			'title'        => 'required|max:200|unique:listings,'.$id,
			'summary'      => 'required',
			'description'  => 'required',
			'website'      => 'url',
			'provider'     => '',
			'category_id'  => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('bundle/edit/'.$id)->with_errors($validator);
		}

		$title = Input::get('title');
		$uri = Str::slug($title, '-');

		$listing = Listing::find($id);
		$listing->title = $title;
		$listing->summary = Input::get('summary');
		$listing->description = Input::get('description');
		$listing->website = Input::get('website');
		$listing->location = Input::get('location');
		$listing->provider = Input::get('provider', 'github');
		$listing->category_id = Input::get('category_id', 1);
		$listing->active = Input::get('active', 'n');
		$listing->user_id = 1; //@todo - Get user id from auth
		$listing->uri = $uri;
		$listing->save();

		// Now save tags
		$this->_save_tags($id);

		// Now save dependencies
		$this->_save_dependencies($id);

		return Redirect::to('bundle/edit/'.$id)
			->with('message', '<strong>Saved!</strong> Your bundle has been saved.')
			->with('message_class', 'success');
	}

	/**
	 * Save Tags
	 *
	 * @param int $id
	 * @return bool
	 */
	private function _save_tags($id)
	{
		$tag = new Tag;
		return $tag->save_tags($id, Input::get('tags'));
	}

	/**
	 * Save Dependencies
	 *
	 * @param int $id
	 * @return bool
	 */
	private function _save_dependencies($id)
	{
		DB::table('dependencies')->where('listing_id', '=', $id)->delete();

		if ( ! $dependencies = Input::get('dependencies'))
		{
			return false;
		}

		foreach ($dependencies as $dependency)
		{
			$bundle = Listing::where_title($dependency)->first();
			if (is_null($bundle))
			{
				continue;
			}
			DB::table('dependencies')->insert(array('listing_id' => $id, 'dependency_id' => $bundle->id));
		}
		return true;
	}

	/**
	 * Bundle detail page
	 *
	 * @param string item
	 * @return string view
	 */
	public function get_detail($item = '')
	{
		$bundle = Listing::where_uri($item)->first();

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
		if ($user = Auth::user()->id)
		{
			if ( ! Rating::where_user_id($user)->where('listing_id', '=', $bundle->id)->get())
			{
				$rating_class = 'active';
			}
			else
			{
				$rating_class = 'rated';
			}
		}

		// Get the total ratings
		$ratings = Rating::where_listing_id($bundle->id)->count();

		return View::make('layouts.default')
			->nest('content', 'bundles.detail', array(
				'bundle' => $bundle,
				'rating_class' => $rating_class,
				'ratings' => $ratings,
			));
	}

	/**
	 * Get a bundle
	 *
	 * This is used via the ajax popover to show a bundle.
	 *
	 * @return string
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