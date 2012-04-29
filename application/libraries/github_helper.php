<?php
/**
 * Github Helper
 *
 * Simple helper for working with github.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Libraries
 * @filesource
 */
class Github_helper {

	/**
	 * Location
	 *
	 * Generate the git location based on the url.
	 *
	 * @param string $url
	 * @return string
	 */
	public static function location($url)
	{
		return str_replace('https://github.com/', '', $url);
	}

	/**
	 * Repos
	 *
	 * Generates a repo array for a select list
	 *
	 * @return array
	 */
	public static function repos()
	{
		$repos = array();

		// Get all the users repos from github
		$all_repos = static::secure_request('user/repos');

		if ( ! $all_repos)
		{
			return array('No github repos found');
		}

		//var_dump($all_repos);
		// See if they have any existing and remove them from the array.
		if ($existing = Listing::where_user_id(Auth::user()->id)->get())
		{
			foreach ($existing as $bundle)
			{
				foreach ($all_repos as $key => $repo)
				{
					if ($bundle->location == static::location($repo->url))
					{
						unset($all_repos[$key]);
					}
				}
			}
		}

		if ( ! isset($all_repos) OR empty($all_repos))
		{
			return array('' => __('form.please_select'));
		}

		// format repos into a sorted select list
		foreach ($all_repos as $key => $row)
		{
			$pushed[$key]  = $row->updated_at;
			$name[$key] = $row->name;
		}

		// Sort by last pushed date. That should make the ones they are wanting to add be
		// at the top of the list
		array_multisort($pushed, SORT_DESC, $name, SORT_ASC, $all_repos);

		// Convert this into an array that can be used by Form::select
		foreach ($all_repos as $repo)
		{
			$repos[$repo->name] = $repo->name;
		}

		// Add the "please select" option as the first item.
		return array_merge(array(__('form.please_select')), $repos);
	}

	/**
	 * Perform a secure github request
	 *
	 * @param  string $url
	 * @return mixed
	 */
	public static function secure_request($url)
	{
		$url = 'https://api.github.com/'.$url.'?'.http_build_query(array(
			'access_token' => Crypter::decrypt(Auth::user()->github_token),
		));
		return static::make_request($url);
	}

	/**
	 * Perform a simple GET type github request
	 *
	 * @param  string $url
	 * @return mixed
	 */
	public static function request($url)
	{
		return static::make_request('https://api.github.com/'.$url);
	}

	/**
	 * Do the curl call to github
	 *
	 * @param  string $url
	 * @return mixed
	 */
	private static function make_request($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$content = curl_exec($ch);
		$headers = curl_getinfo($ch);
		curl_close($ch);
		return ($headers['http_code'] == 200) ? json_decode($content) : null;
	}

	/**
	 * Url Exists
	 *
	 * Check if a url exists on a remote server
	 *
	 * @param string $url
	 * @return bool
	 */
	public static function url_exists($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$content = curl_exec($ch);
		$headers = curl_getinfo($ch);
		curl_close($ch);

		return ($headers['http_code'] == 200) ? true : null;
	}

	/**
	 * Get file
	 *
	 * Uses curl to download a remote file
	 *
	 * @param string $url
	 * @return string
	 */
	public static function get_file($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$content = curl_exec($ch);
		curl_close($ch);
		return $content;
	}

	/**
	 * Markdown
	 *
	 * Take a markdown string and convert it to html.
	 *
	 * @param string $string
	 * @return string html
	 */
	public static function markdown($string)
	{
		require_once(path('bundle').'markdown-extra-extended/markdown_extended.php');
		return MarkdownExtended($string, array('pre' => 'prettyprint'));
	}

	/**
	 * Load Readme
	 *
	 * Attempt to load a repos readme file.
	 *
	 * @param int $user
	 * @param string $repo
	 * @return mixed String on success
	 */
	public static function load_readme($user, $repo)
	{
		$files = array('readme.md', 'readme.markdown', 'readme.txt');
		$url = 'https://raw.github.com/'.$user.'/'.$repo.'/master/';
		foreach ($files AS $file)
		{
			if (static::url_exists($url.$file))
			{
				return static::get_file($url.$file);
			}
		}
		return null;
	}
}