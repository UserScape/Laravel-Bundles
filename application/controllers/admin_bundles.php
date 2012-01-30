<?php
/**
 * Admin bundles controller
 *
 * This controller is used for admins to manage bundles.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Admin_bundles_Controller extends Controller {

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
	 * Setup categories
	 */
	public function __construct()
	{
		$this->filter('before', array('admin_auth'));
		// Get the categories
		$cats = Category::all();
		$this->categories[0] = 'Any Category';
		foreach ($cats as $cat)
		{
			$this->categories[$cat->id] = $cat->title;
		}
	}

	/**
	 * Index
	 *
	 * Show the bundle grid
	 */
	public function get_index()
	{
		// Are we searching?
		if ($cat = Input::get('category') OR $term = strip_tags(Input::get('q')))
		{
			$listings = Listing::order_by('title', 'desc');

			if ($term)
			{
				$listings->where('title', 'LIKE', '%'.$term.'%')
					->or_where('summary', 'LIKE', '%'.$term.'%')
					->or_where('description', 'LIKE', '%'.$term.'%');
			}

			if ($cat > 0)
			{
				$listings->where_category_id($cat);
			}

			$bundles = $listings->paginate(20);
		}
		else
		{
			$bundles = Listing::order_by('updated_at', 'desc')->paginate(20);
		}

		return View::make('layouts.admin')
			->nest('content', 'admin.bundles.grid', array(
				'categories' => $this->categories,
				'bundles' => $bundles,
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
	 * @return mixed Redirects based on status.
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
			'title'        => 'required|max:200|unique:listings,title,'.$id,
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
		// $listing->user_id = 1; //@todo - Get id from the form. See issue #14
		$listing->uri = $uri;
		$listing->save();

		// Now save tags
		$listing->save_tags($id);

		// Now save dependencies
		$listing->save_dependencies($id);

		return Redirect::to('admin_bundles/edit/'.$id)
			->with('message', '<strong>Saved!</strong> Your bundle has been saved.')
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
		if (Input::get('confirm') == 'true')
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

}