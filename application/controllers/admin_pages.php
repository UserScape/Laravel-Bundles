<?php
/**
 * Admin pages controller
 *
 * This controller is used for admins to manage pages.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Admin_pages_Controller extends Controller {

	/**
	 * Tell Laravel we want this class restful. See:
	 * http://laravel.com/docs/start/controllers#restful
	 *
	 * @param bool
	 */
	public $restful = true;

	protected $pages = array();

	public function __construct()
	{
		$pages = Page::all();
		$this->pages = array(0 => '');
		foreach ($pages as $page)
		{
			$this->pages[$page->id] = $page->title;
		}
	}

	/**
	 * Index
	 *
	 * Show the category grid.
	 */
	public function get_index()
	{
		$pages = Page::order_by('order', 'asc')->get();
		return View::make('layouts.admin')
			->nest('content', 'admin.pages.grid', array(
				'pages' => $pages,
			));
	}

	/**
	 * Add a page
	 *
	 * Ability to add a new page
	 */
	public function get_add()
	{
		return View::make('layouts.admin')
			->nest('content', 'admin.pages.form', array(
				'parent_pages' => $this->pages,
			));
	}

	/**
	 * Add a page
	 *
	 * This handles the posted data from the get_add method above.
	 *
	 * @return void Redirects based on status.
	 */
	public function post_add()
	{
		Input::flash();

		$rules = array(
			'title'       => 'required',
			'uri'         => 'unique:pages',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('admin_pages/add')->with_errors($validator);
		}

		$title = Input::get('title');
		if ( ! $uri = Input::get('uri'))
		{
			$uri = Str::slug($title, '-');
		}

		$page = new Page;
		$page->title = $title;
		$page->uri = $uri;
		$page->content = Input::get('content');
		$page->parent = Input::get('parent');
		$page->save();

		return Redirect::to('admin_pages/')
			->with('message', '<strong>Saved!</strong> Your page has been saved.')
			->with('message_class', 'success');
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
		if ( ! $page = Page::find($id))
		{
			return Response::error('404');
		}

		// Pass everything off to the view and assign it where it should go
		return View::make('layouts.admin')
			->nest('content', 'admin.pages.form', array(
				'page' => $page,
				'parent_pages' => $this->pages,
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
			'uri'         => 'unique:pages,'.$id,
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('admin_pages/edit/'.$id)->with_errors($validator);
		}

		$title = Input::get('title');
		if ( ! $uri = Input::get('uri'))
		{
			$uri = Str::slug($title, '-');
		}

		$page = Page::find($id);
		$page->title = $title;
		$page->uri = $uri;
		$page->content = Input::get('content');
		$page->parent = Input::get('parent');
		$page->save();

		return Redirect::to('admin_pages/edit/'.$id)
			->with('message', '<strong>Saved!</strong> Your page has been saved.')
			->with('message_class', 'success');
	}
}