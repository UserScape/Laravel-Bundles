<?php
class Listing extends Eloquent\Model {

	public static $table = 'bundles';

	public static $timestamps = true;

	/**
	 * Find the bundle either by id or string
	 */
	public static function find($id)
	{
		if (is_numeric($id))
		{
			return parent::find($id);
		}
		else
		{
			return parent::where('uri', '=', $id)->first();
		}
	}

	/**
	 * Get the user
	 *
	 * @return mixed
	 */
	public function user()
	{
		return $this->has_one('User');
	}

	/**
	 * Get all its tags
	 */
	public function tags()
	{
		return $this->has_and_belongs_to_many('Tag', 'bundle_tags', 'bundle_id');
	}

	/**
	 * Get all its dependencies
	 */
	public function dependencies()
	{
		return $this->has_and_belongs_to_many('Listing', 'dependencies', 'bundle_id', 'dependency_id');
	}
}
