<?php

class User_Controller extends Controller {

	public function action_index()
	{
		$user = new User;
		return View::make('home.index');
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

		// @todo - Move these to config.
		$provider = OAuth2::provider($provider, array(
			'id' => '5cadb2b49f5975a8760a',
			'secret' => '265ea9eb57184a294e8fa61766e16c47e4f9b130',
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

				// Save the user data
				$user = new User;
				$user->username = $github_user['nickname'];
				$user->name = $github_user['name'];
				$user->email = $github_user['email'];
				$user->ip_address = Request::ip();
				$user->github_uid = $github_user['uid'];
				$user->github_token = Crypter::encrypt($params->access_token);
				$user->save();

				if (Auth::attempt($github_user['nickname'], $params->access_token))
				{
					return Redirect::to('');
				}
			}
			catch (Exception $e)
			{
				// I am hiding the exception and will just redirect with a message
				return Redirect::to('/');
			}
		}
	}
}