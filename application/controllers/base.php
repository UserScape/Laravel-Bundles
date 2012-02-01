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
		if (Config::get('application.minify_js'))
		{
			Asset::add('jquery', 'js/min/jquery-min.js');
			Asset::add('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js', 'jquery');
			Asset::add('jquery-tags', 'js/min/jquery.tagit-min.js', array('jquery','jquery-ui'));
			Asset::add('pretty', 'js/google-code-prettify/prettify.js', array('jquery', 'jquery-ui', 'jquery-tags'));
			Asset::add('tools', 'http://cdn.jquerytools.org/1.2.6/form/jquery.tools.min.js', array('jquery'));
			Asset::add('bootstrap', 'js/min/bootstrap-min.js', array('jquery'));
			Asset::add('main', 'js/min/jquery.main-min.js', array('jquery', 'jquery-ui', 'jquery-tags'));
		}
		else
		{
			Asset::add('jquery', 'js/jquery.min.js');
			Asset::add('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js', 'jquery');
			Asset::add('jquery-tags', 'js/jquery.tagit.js', array('jquery','jquery-ui'));
			Asset::add('pretty', 'js/google-code-prettify/prettify.js', array('jquery', 'jquery-ui', 'jquery-tags'));
			Asset::add('tools', 'http://cdn.jquerytools.org/1.2.6/form/jquery.tools.min.js', array('jquery'));
			Asset::add('bootstrap', 'js/bootstrap.min.js', array('jquery'));
			Asset::add('main', 'js/jquery.main.js', array('jquery', 'jquery-ui', 'jquery-tags'));
		}
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