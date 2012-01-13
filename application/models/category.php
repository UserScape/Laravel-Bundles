<?php
class Category extends Eloquent\Model {

	public static $table = 'categories';

	public static $per_page = 10;

	/**
	 * Find a category
	 *
	 * @param mixed $id - int or string
	 * @return mixed
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
	 * Get bundles in a category
	 *
	 * @return mixed
	 */
	public function bundles()
	{
		return $this->has_many('Listing');
	}
}
