<?php
class Nav {

	public static function active($route = '')
	{
		return (Request::route()->handles($route)) ? 'active' : false;
	}
}