<?php
/**
 * Base controller
 *
 * This is used to setup the assets global across all controllers
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Base_Controller extends Controller {

	public $layout = 'layouts.default';

	/**
	 * Construct
	 *
	 * Setup all the assets
	 *
	 * @todo - Compress these into one. This is nasty.
	 */
	public function __construct()
	{
		Asset::add('style', 'css/style.css');
		Asset::add('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js', 'jquery');
		Asset::add('jquery-tags', 'js/jquery.tagit.js', array('jquery','jquery-ui'));
		Asset::add('tools', 'http://cdn.jquerytools.org/1.2.6/form/jquery.tools.min.js', array('jquery'));
		Asset::add('main', 'js/jquery.main.js', array('jquery-tags'));
	}

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}
}