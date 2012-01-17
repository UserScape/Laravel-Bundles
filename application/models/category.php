<?php
class Category extends Eloquent\Model {

	public static $table = 'categories';

	public static $per_page = 10;

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
