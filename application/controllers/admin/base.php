<?php
/**
 * Admin Base controller
 *
 * This is used as a global admin controller to setup assets and handle auth.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Admin_Base_Controller extends Controller {

	/**
	 * Construct
	 *
	 * Setup all the assets
	 *
	 * @todo - Compress these into one. This is nasty.
	 */
	public function __construct()
	{
		$this->filter('before', array('admin_auth'));

		Asset::add('style', 'css/admin.css');
		Asset::add('jquery', 'js/jquery.min.js');
		// Asset::add('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js');
		Asset::add('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js', 'jquery');
		Asset::add('jquery-tags', 'js/jquery.tagit.js', array('jquery','jquery-ui'));
		Asset::add('tools', 'http://cdn.jquerytools.org/1.2.6/form/jquery.tools.min.js', array('jquery'));
		Asset::add('bootstrap', 'js/bootstrap.min.js', array('jquery'));
		Asset::add('main', 'js/jquery.main.js', array('jquery', 'jquery-ui', 'jquery-tags'));
	}

	/**
	 * Error Override
	 *
	 * This is used to throw a 404 page with our
	 * layout data assigned.
	 *
	 */
	public function __call($method, $args)
	{
		return Response::error('404', $data);
	}
}