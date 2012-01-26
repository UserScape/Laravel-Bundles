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
		require_once(APP_PATH.'/libraries/markdown.php');
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