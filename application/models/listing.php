<?php
/**
 * Listing
 *
 * Model for handling the listings/bundles table.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Models
 * @filesource
 */
class Listing extends Eloquent\Model {

	/**
	 * Manually set the table
	 * @param string $table
	 */
	public static $table = 'listings';

	/**
	 * Use timestamps
	 * @param bool $timestamps
	 */
	public static $timestamps = true;

	/**
	 * Get the user
	 *
	 * @return mixed
	 */
	public function user()
	{
		return $this->belongs_to('User');
	}

	/**
	 * Get all its tags
	 */
	public function tags()
	{
		return $this->has_and_belongs_to_many('Tag', 'listing_tags', 'listing_id');
	}

	/**
	 * Get all its dependencies
	 */
	public function dependencies()
	{
		return $this->has_and_belongs_to_many('Listing', 'dependencies', 'listing_id', 'dependency_id');
	}

	/**
	 * Save Tags
	 *
	 * @param int $id
	 * @return bool
	 */
	public function save_tags($id)
	{
		$tag = new Tag;
		return $tag->save_tags($id, Input::get('tags'));
	}

	/**
	 * Save Dependencies
	 *
	 * @param int $id
	 * @return bool
	 */
	public function save_dependencies($id)
	{
		DB::table('dependencies')->where('listing_id', '=', $id)->delete();

		if ( ! $dependencies = Input::get('dependencies'))
		{
			return false;
		}

		foreach ($dependencies as $dependency)
		{
			// Rest the where clause to keep from have the wrong query.
			self::reset_where();

			$bundle = self::where_title($dependency)->first();
			if (is_null($bundle))
			{
				continue;
			}
			DB::table('dependencies')->insert(array('listing_id' => $id, 'dependency_id' => $bundle->id));
		}
		return true;
	}
}
