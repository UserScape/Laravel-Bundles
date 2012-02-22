<?php
/**
 * Categories controller
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
class Categories_Controller extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Index
	 *
	 * Show all categories
	 */
	public function action_index()
	{
		return View::make('layouts.default')
			->with('title', 'Categories')
			->nest('content', 'category.grid');
	}
}