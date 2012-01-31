<?php
/**
 * Category controller
 *
 * Allows users to filter bundles by specific categories.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Category_Controller extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Detail
	 *
	 * Load a category by its uri and display bundles.
	 *
	 * @param string $cat
	 */
	public function action_detail($cat = '')
	{
		if ( ! $category = Category::where_uri($cat)->first())
		{
			return Response::error('404');
		}

		$bundles = Listing::where_active('y')
			->where_category_id($category->id)
			->paginate(Config::get('application.per_page'));

		return View::make('layouts.default')
			->with('title', $category->title)
			->nest('content', 'category.detail', array(
				'category' => $category,
				'bundles' => $bundles
			));
	}
}
