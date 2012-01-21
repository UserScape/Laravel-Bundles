<?php
/**
 * Home controller
 *
 * Responsible for building the home page.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Home_Controller extends Controller {

	/**
	 * Home page
	 *
	 * Handles all the queries to get the home page data
	 *
	 * @return mixed
	 */
	public function action_index()
	{
		// Get the last updated listings
		$latest = DB::table('listings')
			->where_active('y')
			->order_by('updated_at', 'desc')
			->take(5)
			->get();

		$categories = Category::all();

		// Get the most popular
		$ratings = DB::query('SELECT listing_id, COUNT(*) as total FROM rating GROUP BY listing_id ORDER BY total desc');

		$ratings_in = array();
		foreach ($ratings as $item)
		{
			$ratings_in[] = $item->listing_id;
		}

		// Now get the listing info
		$popular = DB::table('listings')
			->where_active('y')
			->where_in('id', $ratings_in)
			->take(5)
			->get();

		// var_dump(Laravel\Database\Connection::$queries);

		return View::make('layouts.home')
			->nest('content', 'home.index', array(
				'latest' => $latest,
				'popular' => $popular,
				'categories' => $categories,
			));
	}
}