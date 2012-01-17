<?php
class Listing extends Eloquent\Model {

	public static $table = 'listings';

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
}
