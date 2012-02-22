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

	/**
	 * Index
	 *
	 * Show all categories
	 */
	public function action_index()
	{
		return $this->layout->with('title', 'Categories')
			->nest('content', 'bundles::category.grid');
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
			->order_by('updated_at', 'desc')
			->paginate(Config::get('application.per_page'));

		return $this->layout->with('title', $category->title)
			->nest('content', 'category.detail', array(
				'category' => $category,
				'bundles' => $bundles
			));
	}
}
