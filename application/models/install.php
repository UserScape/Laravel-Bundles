<?php
/**
 * Install
 *
 * Model for handling the install log table.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Models
 * @filesource
 */
class Install extends Eloquent {

	/**
	 * Manually set the table
	 * @param string $table
	 */
	public static $table = 'installs';

	/**
	 * Tell eloquent to use timestamps
	 * @param bool $timestamps
	 */
	public static $timestamps = true;

}
