<?php
/**
 * Rss controller
 *
 * Subscribe to the rss feed
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Rss_Controller extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
		header("Content-Type: application/rss+xml");
	}

	/**
	 * Index
	 *
	 * Show the list of latest bundles
	 */
	public function action_index()
	{
		$bundles = Listing::where_active('y')
			->order_by('created_at', 'desc')
			->take(10)
			->get();

		return View::make('rss.default')
			->with('bundles', $bundles);
	}

	/**
	 * Category
	 *
	 * Show the rss feed based on a category.
	 *
	 * @param string $cat
	 */
	public function action_category($cat = '')
	{
		$category = Category::where_uri($cat)->first();

		$bundles = Listing::where_active('y')
			->where_category_id($category->id)
			->order_by('created_at', 'desc')
			->take(10)
			->get();

		return View::make('rss.default')
			->with('bundles', $bundles);
	}

	/**
	 * User
	 *
	 * Show the rss feed based on a user.
	 *
	 * @param string $username
	 */
	public function action_user($usernane = '')
	{
		$user = User::where_username($usernane)->first();

		$bundles = Listing::where_active('y')
			->where_user_id($user->id)
			->order_by('created_at', 'desc')
			->take(10)
			->get();

		return View::make('rss.default')
			->with('bundles', $bundles);
	}
}
