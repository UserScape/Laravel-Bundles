<?php
/**
 * Admin cats controller
 *
 * This controller is used for admins to manage categories.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Admin_Cats_Controller extends Admin_Base_Controller {

	/**
	 * Tell Laravel we want this class restful. See:
	 * http://laravel.com/docs/start/controllers#restful
	 *
	 * @param bool
	 */
	public $restful = true;

	/**
	 * Construct
	 *
	 * Setup the parent base controller
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Index
	 *
	 * Show the category grid.
	 *
	 * @return string
	 */
	public function get_index()
	{
		$categories = Category::order_by('title', 'asc')->get();
		$cat_select = array();
		foreach ($categories as $cat)
		{
			$cat_select[$cat->id] = $cat->title;
		}
		return View::make('layouts.admin')
			->nest('content', 'admin.categories.grid', array(
				'categories' => $categories,
				'cat_select' => $cat_select,
			));
	}

	/**
	 * Add a bundle
	 *
	 * Ability to add a new category
	 *
	 * @return string
	 */
	public function get_add()
	{
		return View::make('layouts.admin')
			->nest('content', 'admin.categories.form', array(
				'category' => array(),
			));
	}

	/**
	 * Add a category
	 *
	 * This handles the posted data from the get_add method above.
	 *
	 * @return string
	 */
	public function post_add()
	{
		Input::flash();

		$rules = array(
			'title'       => 'required',
			'uri'         => 'required|unique:categories',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('admin/cats/add')->with_errors($validator);
		}

		$title = Input::get('title');
		$uri = Str::slug(Input::get('uri'), '-');

		$cat = new Category;
		$cat->title = $title;
		$cat->uri = $uri;
		$cat->description = Input::get('description');
		$cat->save();

		return Redirect::to('admin/cats/')
			->with('message', '<strong>Saved!</strong> Your category has been saved.')
			->with('message_class', 'success');
	}

	/**
	 * Edit a category
	 *
	 * Create the form which will send the posted
	 * data to the post_edit method.
	 *
	 * @param int $id
	 * @return string
	 */
	public function get_edit($id = 0)
	{
		// See if we can get the bundle
		if ( ! $cat = Category::find($id))
		{
			return Response::error('404');
		}

		// Pass everything off to the view and assign it where it should go
		return View::make('layouts.admin')
			->nest('content', 'admin.categories.form', array(
				'category' => $cat,
			));
	}

	/**
	 * Edit a category
	 *
	 * This handles the posted data from the get_edit method above.
	 *
	 * @param int $id
	 * @return string
	 */
	public function post_edit($id = 0)
	{
		// Make sure we are valid.
		if ( ! is_numeric($id))
		{
			return Response::error('404');
		}

		Input::flash();

		$rules = array(
			'title'       => 'required',
			'uri'         => 'required|unique:categories,uri,'.$id,
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('admin/cats/edit/'.$id)->with_errors($validator);
		}

		$title = Input::get('title');
		$uri = Str::slug(Input::get('uri'), '-');

		$cat = Category::find($id);
		$cat->title = $title;
		$cat->uri = $uri;
		$cat->description = Input::get('description');
		$cat->save();

		return Redirect::to('admin/cats/edit/'.$id)
			->with('message', '<strong>Saved!</strong> Your category has been saved.')
			->with('message_class', 'success');
	}

	/**
	 * Delete
	 *
	 * Delete a category
	 *
	 * @return string json
	 */
	public function post_delete()
	{
		$id = Input::get('id');
		$new_id = Input::get('category');

		if ($cat = Category::find($id))
		{
			$cat->delete();

			// Change the category for all bundles
			$affected = DB::table('listings')
                    ->where('category_id', '=', $id)
                    ->update(array('category_id' => $new_id));

			return json_encode(array('success' => true));
		}
		return json_encode(array('error' => true));
	}

}