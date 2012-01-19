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
	protected $groups = array(
		0 => 'Any Group',
		1 => 'Administrator',
		2 => 'Normal User',
	);

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
		$user->group = Input::get('group');
		$user->save();

		return Redirect::to('admin_users/edit/'.$id)
			->with('message', '<strong>Saved!</strong> Your bundle has been saved.')
			->with('message_class', 'success');
	}
}