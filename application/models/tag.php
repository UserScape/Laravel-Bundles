<?php
class Tag extends Eloquent\Model {

	public static $table = 'tags';

	public function bundles()
	{
		return $this->has_many('Listing');
	}
}