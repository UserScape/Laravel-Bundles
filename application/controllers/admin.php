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
class Admin_Controller extends Controller {

	/**
	 * Action Index
	 *
	 * Load the dashboard
	 */
	public function action_index()
	{
		return View::make('layouts.admin')
			->nest('content', 'admin.index', array(
				'categories' => array(),
			));
	}
}
