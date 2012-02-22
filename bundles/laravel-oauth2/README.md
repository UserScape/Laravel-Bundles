# Laravel OAuth 2.0

**This is based on the CodeIgniter OAuth2 Spark maintained by Phil Sturgeon**

Authorize users with your application in a driver-base fashion meaning one implementation works for multiple OAuth 2 providers. This is only to authenticate onto OAuth2 providers and not to build an OAuth2 service.

Note that this Spark ONLY provides the authorization mechanism. There's an example controller below, however in a later version there will be a full controller.

## Currently Supported

- Facebook
- GitHub
- Google
- Windows Live
- YouTube

## Usage Example

http://example.com/auth/session/facebook

```php
public function action_session($provider)
{
	Bundle::start('laravel-oauth2');
	
	$provider = OAuth2::provider($provider, array(
		'id' => 'your-client-id',
		'secret' => 'your-client-secret',
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
			
			$user = $provider->get_user_info($params['access_token']);
			
			// Here you should use this information to A) look for a user B) help a new user sign up with existing data.
			// If you store it all in a cookie and redirect to a registration page this is crazy-simple.
			echo "<pre>";
			var_dump($user);
		}
		
		catch (OAuth2_Exception $e)
		{
			show_error('That didnt work: '.$e);
		}
		
	}
}
```
