<?php
/**
 * Bundles controller
 *
 * This is used for basic bundle crud operations as well as
 * displaying the bundle details page.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Bundles_Controller extends Base_Controller {

	/**
	 * Construct
	 *
	 * Pull out needed items and assign assets.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * Add a bundle
	 *
	 * Create the add bundle form which will send the posted
	 * data to the post_add method.
	 *
	 * @return string
	 */
	public function action_index()
	{
		$bundles = Listing::where_active('y')
			->order_by('updated_at', 'desc')
			->paginate(Config::get('application.per_page'));

		return View::make('layouts.default')
			->with('title', 'All Bundles')
			->nest('content', 'category.detail', array(
				'category' => $category,
				'bundles' => $bundles
			));
	}

	/**
	 * Popular Listings
	 * @return string
	 */
	public function action_popular()
	{
		$bundles = null;
		if ($ratings = DB::query('SELECT listing_id, COUNT(*) as total FROM rating GROUP BY listing_id ORDER BY total desc'))
		{
			$ratings_in = array();
			foreach ($ratings as $item)
			{
				$ratings_in[] = $item->listing_id;
			}

			// Now get the listing info
			$bundles = DB::table('listings')
				->where_active('y')
				->where_in('listings.id', $ratings_in)
				->left_join('users', 'users.id', '=', 'listings.user_id')
				->paginate(Config::get('application.per_page'));
		}

		return View::make('layouts.default')
			->with('title', 'All Bundles')
			->nest('content', 'category.detail', array(
				'category' => $category,
				'cat_title' => 'Most Popular',
				'bundles' => $bundles
			));
	}
}