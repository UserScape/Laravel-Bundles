<?php
class Listing extends Eloquent\Model {

	public static $table = 'bundles';

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

	public function tags()
	{
		return $this->has_and_belongs_to_many('Tag');
	}
}
