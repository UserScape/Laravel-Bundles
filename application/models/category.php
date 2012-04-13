<?php
/**
 * Category
 *
 * Eloquent category model.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Models
 * @filesource
 */
class Category extends Eloquent {

	/**
	 * Manually assign the table.
	 * @param string $table
	 */
	public static $table = 'categories';

	/**
	 * Get bundles in a category
	 *
	 * @return mixed
	 */
	public function bundles()
	{
		return $this->has_many('Listing');
	}
}
