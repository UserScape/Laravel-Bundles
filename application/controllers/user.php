<?php
/**
 * User controller
 *
 * Basic user operations. Login, logout, and view their bundles.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class User_Controller extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Index
	 *
	 * Show a login form or login text.
	 */
	public function action_index($item = '')
	{
		$user = User::where_username($item)->first();

		if ($user)
		{
			$bundles = Listing::where_active('y')
				->where_user_id($user->id)
				->paginate(Config::get('application.per_page'));
		}
		else
		{
			$bundles = null;
		}

		return View::make('layouts.default')
			->nest('content', 'user.bundles', array(
				'user' => $user,
				'bundles' => $bundles
			));
	}

	/**
	 * User Login
	 *
	 * This handles the oauth request with the provider
	 *
	 * @param string $provider
	 * @return void
	 */
	public function action_login($provider = 'github')
	{
		Bundle::start('laravel-oauth2');

		$provider = OAuth2::provider($provider, array(
			'id' => Config::get('github.id'),
			'secret' => Config::get('github.secret'),
		));

		if ( ! isset($_GET['code']))
		{
			return $provider->authorize();
		}
		else
		{
			// After we have the access token we need to store it so we can make api calls later.
			try
			{
				$params = $provider->access($_GET['code']);
				$github_user = $provider->get_user_info($params);

				// Save or update the user data
				if ($existing = User::where('username', '=', $github_user['nickname'])->first())
				{
					$existing->ip_address = Request::ip();
					$existing->github_uid = $github_user['uid'];
					$existing->github_token = Crypter::encrypt($params->access_token);
					$existing->save();
				}
				else
				{
					$user = new User;
					$user->username = $github_user['nickname'];
					$user->name = ($github_user['name'] ?: '');
					$user->email = ($github_user['email'] ?: '');
					$user->ip_address = Request::ip();
					$user->github_uid = $github_user['uid'];
					$user->github_token = Crypter::encrypt($params->access_token);
					$user->group_id = (User::count() == 0) ? 1 : 2;
					$user->save();
				}

				if (Auth::attempt($github_user['nickname'], $params->access_token, true))
				{
					if ($goto = Session::get('goto'))
					{
						$goto = strip_tags($goto);
						$goto = str_replace('.', '', $goto);
						return Redirect::to($goto);
					}
					return Redirect::to('/');
				}
			}
			catch (Exception $e)
			{
				// I am hiding the exception and will just redirect with a message
				return Redirect::to('/');
			}
		}
	}

	/**
	 * Bundles
	 *
	 * Show a list of the current users bundles
	 *
	 * @return string
	 */
	public function action_bundles()
	{
		$bundles = Listing::where_user_id(Auth::user()->id)
			->paginate(Config::get('application.per_page'));

		return View::make('layouts.default')
			->nest('content', 'user.listings', array(
				'category' => $category,
				'bundles' => $bundles
			));
	}

	/**
	 * Logout
	 *
	 * Allow the user to logout and redirect to home.
	 */
	public function action_logout()
	{
		Auth::logout();
		return Redirect::to('/');
	}
}