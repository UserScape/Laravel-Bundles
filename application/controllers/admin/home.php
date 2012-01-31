<?php
/**
 * Admin controller is used to set up the admin dashboard
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Admin_Home_Controller extends Admin_Base_Controller {

	/**
	 * Construct
	 *
	 * Setup the parent base controller
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Action Index
	 *
	 * Load the dashboard
	 */
	public function action_index()
	{
		$this->filter('before', array('admin_auth'));

		// Get the new listings
		$new = DB::table('listings')
			->order_by('created_at', 'desc')
			->take(5)
			->get();

		// Get the last updated listings
		$updated = DB::table('listings')
			->order_by('updated_at', 'desc')
			->take(5)
			->get();

		return View::make('layouts.admin')
			->nest('content', 'admin.index', array(
				'categories' => array(),
				'new' => $new,
				'updated' => $updated
			));
	}
}
