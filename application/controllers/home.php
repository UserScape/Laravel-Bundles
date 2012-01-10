<?php

class Home_Controller extends Controller {

	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| To start using this controller, simply remove the default route from the
	| application "routes.php" file. Laravel is smart enough to find this
	| controller and call the default method, which is "action_index".
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/

	public function action_index()
	{
		return View::make('home.index');
	}

	public function action_session($provider)
	{
		Bundle::start('laravel-oauth2');

		$provider = OAuth2::provider($provider, array(
			'id' => '5cadb2b49f5975a8760a',
			'secret' => '265ea9eb57184a294e8fa61766e16c47e4f9b130',
		));

		if ( ! isset($_GET['code']))
		{
			// By sending no options it'll come back here
			return $provider->authorize();
		}
		else
		{
			// Howzit?
			try
			{
				$params = $provider->access($_GET['code']);
				var_dump($params);

				$user = $provider->get_user_info($params['access_token']);

				// Here you should use this information to A) look for a user B) help a new user sign up with existing data.
				// If you store it all in a cookie and redirect to a registration page this is crazy-simple.
				echo "<pre>";
				var_dump($user);
			}

			catch (Exception $e)
			{
				var_dump('That didnt work: '.$e);
			}
		}
	}
}