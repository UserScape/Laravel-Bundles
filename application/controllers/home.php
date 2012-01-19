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
	 * @todo finish this.
	 */
	public function action_index()
	{
		$latest = DB::table('listings')
			->where_active('y')
			->order_by('created_at', 'desc')
			->take(10)
			->get();

		$categories = Category::all();

		// var_dump(Laravel\Database\Connection::$queries);

		return View::make('layouts.home')
			->nest('content', 'home.index', array(
				'latest' => $latest,
				'categories' => $categories,
			));
	}
}