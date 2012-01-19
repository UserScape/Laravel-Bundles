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
class Admin_cats_Controller extends Controller {

	/**
	 * Tell Laravel we want this class restful. See:
	 * http://laravel.com/docs/start/controllers#restful
	 *
	 * @param bool
	 */
	public $restful = true;

	/**
	 * Index
	 *
	 * Show the category grid.
	 */
	public function get_index()
	{
		$categories = Category::order_by('title', 'asc')->get();
		return View::make('layouts.admin')
			->nest('content', 'admin.categories.grid', array(
				'categories' => $categories,
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
			'title'       => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('admin_cats/edit/'.$id)->with_errors($validator);
		}

		$title = Input::get('title');
		$uri = Str::slug($title, '-');

		$cat = Category::find($id);
		$cat->title = $title;
		$cat->uri = $uri;
		$cat->description = Input::get('description');
		$cat->save();

		return Redirect::to('admin_cats/edit/'.$id)
			->with('message', '<strong>Saved!</strong> Your category has been saved.')
			->with('message_class', 'success');
	}
}