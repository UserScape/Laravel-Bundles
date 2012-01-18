<?php
class Nav {

	protected static $all = array();

	public static function active($route = '')
	{
		return (Request::route()->handles($route)) ? 'active' : '';
	}

	public static function cat($route = '')
	{
		return (URI::current() == $route) ? 'active' : '';
	}

	public static function cat_count($cat)
	{
		if (empty(self::$all))
		{
			self::$all = Listing::where_active('y')->get();
		}

		$count = 0;

		foreach (self::$all as $item)
		{
			if ($item->category_id == $cat)
			{
				$count++;
			}
		}

		return $count;
	}
}