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
class Home_Controller extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
	}

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
			->order_by('listings.updated_at', 'desc')
			->left_join('users', 'users.id', '=', 'listings.user_id')
			->take(5)
			->get(array('title', 'uri', 'listings.created_at', 'summary', 'class', 'username', 'name'));

		$categories = Category::all();

		$popular = null;

		// Get the most popular
		$popular = DB::query('SELECT listings.*, users.username, users.name, rating.listing_id, COUNT(*) as total FROM rating LEFT JOIN listings ON listings.id = rating.listing_id INNER JOIN users ON listings.user_id = users.id GROUP BY listing_id ORDER BY total desc LIMIT 5');

		$featured = DB::table('listings')
			->where_active('y')
			->where('class', 'like', '%featured%')
			->left_join('users', 'users.id', '=', 'listings.user_id')
			->first();

		// var_dump(Laravel\Database\Connection::$queries);

		return View::make('layouts.home')
			->nest('content', 'home.index', array(
				'latest' => $latest,
				'popular' => $popular,
				'featured' => $featured,
				'categories' => $categories,
			));
	}
}