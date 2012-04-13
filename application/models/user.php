<?php
/**
 * User
 *
 * Model for handling the users.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Models
 * @filesource
 */
class User extends Eloquent {

	public static $table = 'users';

	public static $timestamps = true;

	public function listings()
	{
		return $this->has_many('Listing');
	}
}
