<?php
/**
 * Gravatar
 *
 * A library to generate gravatar icons
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   John Crepezzi
 * @author      John Crepezzi
 * @link        https://github.com/seejohnrun/gravatar_helper
 * @package     Laravel-Bundles
 * @subpackage  Libraries
 * @filesource
 */
class Gravatar {

	// The gravatar base URL
	private static $image_base_url = 'http://gravatar.com/avatar.php';
	private static $profile_base_url = 'http://gravatar.com/';

	/*
	 * Generate a gravatar link from an email address
	 *
	 * $email: The email to generate the link for
	 * +++ all the other arguments for gravatar_hash()
	 */
	public static function from_email($email, $size = null, $rating = null, $default = null)
	{
		return self::from_hash(md5($email), $rating, $size, $default);
	}

	/*
	 * Generate a gravatar link from an email hash
	 *
	 * $hash: the hash to generate the link for
	 * $rating: the rating ('G', 'R', 'X')
	 * $size: The size (square) of the desired image
	 * $default: The default image if the user doesn't have one
	 */
	public static function from_hash($hash, $rating = null, $size = null, $default = null)
	{
		// Add the gravatar id
		$options = array();
		$options[] = "gravatar_id=$hash";
		// optional options
		if ($rating) $options[] = "rating=$rating";
		if ($size) $options[] = "size=$size";
		if ($default) $options[] = "default=$default";
		// put together the URL and return it
		return self::$image_base_url . '?' . implode($options, '&');
	}

	/*
	 * Get the profile of a user by email, or null if not found
	 *
	 * $email: the email to fetch the profile for
	 */
	public static function profile_from_email($email)
	{
		return self::profile_from_hash(md5($email));
	}

	/*
	 * Get the profile of a user by email hash, or null if not found
	 *
	 * $hash: the hash to fetch the profile for
	 */
	public static function profile_from_hash($hash)
	{
		if ($raw = file_get_contents(self::$profile_base_url . $hash . '.json'))
		{
			$data = json_decode($raw);
			$entry = $data->entry;
			return $entry[0];
		}
		else
		{
			return null;
		}
	}
}