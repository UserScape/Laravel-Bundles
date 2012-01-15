<?php
class User extends Eloquent\Model {
	public static $table = 'users';
	public static $timestamps = true;

	public function bundles()
	{
		return $this->has_many('Listing');
	}
}
