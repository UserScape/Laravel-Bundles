<?php
/**
 * Admin users controller
 *
 * This controller is used for admins to manage users.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Admin_users_Controller extends Controller {

	/**
	 * Tell Laravel we want this class restful. See:
	 * http://laravel.com/docs/start/controllers#restful
	 *
	 * @param bool
	 */
	public $restful = true;

	/**
	 * Array of user groups.
	 *
	 * @param array
	 */
	protected $groups = array(
		0 => 'Any Group',
		1 => 'Administrator',
		2 => 'Normal User',
	);

	/**
	 * Construct
	 *
	 * Setup the auth
	 */
	public function __construct()
	{
		$this->filter('before', array('admin_auth'));
	}

	/**
	 * Index
	 *
	 * Show the bundle newt_grid_free(grid, recurse)
	 */
	public function get_index()
	{
		// Are we searching?
		if ($group = Input::get('group') OR $term = strip_tags(Input::get('q')))
		{
			$users_query = User::order_by('username', 'asc');

			if ($term)
			{
				$users_query->where('name', 'LIKE', '%'.$term.'%')
					->or_where('username', 'LIKE', '%'.$term.'%')
					->or_where('email', 'LIKE', '%'.$term.'%');
			}

			if ($group > 0)
			{
				$users_query->where('group_id', '=', $group);
			}
			$users = $users_query->paginate(20);
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
		if ( ! $user = User::find($id))
		{
			return Response::error('404');
		}

		// Pass everything off to the view and assign it where it should go
		return View::make('layouts.admin')
			->nest('content', 'admin.users.form', array(
				'groups' => $this->groups,
				'user' => $user,
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
			'name'       => 'required',
			'username'   => 'required|max:200|unique:users,'.$id,
			'email'      => 'email',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('admin_users/edit/'.$id)->with_errors($validator);
		}

		$user = User::find($id);
		$user->username = Input::get('username');
		$user->name = Input::get('name');
		$user->email = Input::get('email');
		$user->group_id = Input::get('group');
		$user->save();

		return Redirect::to('admin_users/edit/'.$id)
			->with('message', '<strong>Saved!</strong> Your bundle has been saved.')
			->with('message_class', 'success');
	}
}