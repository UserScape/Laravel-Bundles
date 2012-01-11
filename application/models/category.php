<?php
class Category extends Eloquent\Model {

	public static $table = 'categories';

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

	public function bundles()
	{
		return $this->has_many('Listing');
	}
}
