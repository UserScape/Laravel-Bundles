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
				$user = $provider->get_user_info($params);

				// Save the user data
				$user = new User;
				$user->username = $user->nickname;
				$user->name = $user->name;
				$user->email = $user->email;
				$user->ip_address = 'secret';
				$user->github_uid = $user->uid;
				$user->github_token = $params->acccess_token;
				$user->save();
			}
			catch (Exception $e)
			{
				var_dump($e);
			}
		}
	}
}