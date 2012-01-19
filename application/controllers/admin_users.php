<?php

class Admin_users_Controller extends Controller {

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
	protected $groups = array(0 => 'Any Group');

	/**
	 * Construct
	 *
	 * Setup categories
	 */
	public function __construct() {}

	/**
	 * Index
	 *
	 * Show the bundle newt_grid_free(grid, recurse)
	 */
	public function get_index()
	{
		// Are we searching?
		// @todo - This aint working but I am moving on to something more important.
		// can't get my ahead around best way of doing it.
		if ($cat = Input::get('category') OR $term = strip_tags(Input::get('q')))
		{
			$bundles = Listing::where('1', '=', '1');

			if ($term)
			{
				$bundles->where('title', 'LIKE', '%'.$term.'%')
					->or_where('summary', 'LIKE', '%'.$term.'%')
					->or_where('description', 'LIKE', '%'.$term.'%');
			}

			if ($cat > 0)
			{
				$bundles->where('category_id', '=', $cat);
			}
			$bundles->paginate(20);

			var_dump(Laravel\Database\Connection::$queries);
		}
		else
		{
			$users = User::order_by('username', 'asc')->paginate(20);
		}

		return View::make('layouts.admin')
			->nest('content', 'admin.users.grid', array(
				'groups' => $this->groups,
				'users' => $users,
			));
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
		return View::make('layouts.admin')
			->nest('content', 'admin.bundles.form', array(
				'categories' => $this->categories,
				'bundle' => $bundle,
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
			return Redirect::to('admin_bundles/edit/'.$id)->with_errors($validator);
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
		// $listing->user_id = 1; //@todo - Get id from the form.
		$listing->uri = $uri;
		$listing->save();

		// Now save tags
		$this->_save_tags($id);

		// Now save dependencies
		$this->_save_dependencies($id);

		return Redirect::to('admin_bundles/edit/'.$id)
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

}