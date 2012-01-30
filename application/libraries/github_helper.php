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

	public static function setup()
	{
		require_once path('app').'libraries/Github/Autoloader.php';
		Github_Autoloader::register();
		return new Github_Client();
	}

	/**
	 * Setup GitHub
	 *
	 * Includes the api and sets up the repo list
	 *
	 * @return array
	 */
	public static function repos()
	{
		$github = self::setup();

		$repos = array();

		if ($all_repos = $github->getRepoApi()->getUserRepos(Auth::user()->username))
		{
			// format repos into a select list
			foreach ($all_repos as $repo)
			{
				$repos[$repo['name']] = $repo['name'];
			}
		}
		sort($repos);
		$repos[0] = __('form.please_select');
		return $repos;
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
		curl_setopt($ch,CURLOPT_URL,$url);
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
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,1);
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
		require_once(path('app').'/libraries/markdown.php');
		return markdown($string);
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
			if (self::url_exists($url.$file))
			{
				$file = self::get_file($url.$file);
				return $file; // self::markdown($file);
			}
		}
		return null;
	}
}