<?php
/**
 * Bundle
 *
 * Basic laravel settings
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Models
 * @filesource
 * @todo        This is nasty and needs refactoring
 */

/**
 * Home page composer
 */
View::composer('layouts.home', function($view)
{
	$view->with('categories', Category::all());
	Asset::add('style', 'css/bootstrap.css');
	Asset::add('jquery', 'js/jquery.min.js');
	// Asset::add('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js');
	Asset::add('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js', 'jquery');
	Asset::add('jquery-tags', 'js/jquery.tagit.js', array('jquery','jquery-ui'));
	Asset::add('pretty', 'js/google-code-prettify/prettify.js', array('jquery', 'jquery-ui', 'jquery-tags'));
	Asset::add('tools', 'http://cdn.jquerytools.org/1.2.6/form/jquery.tools.min.js', array('jquery'));
	Asset::add('bootstrap-modal', 'js/bootstrap-modal.js', array('jquery'));
	//Asset::add('bootstrap-alerts', 'js/bootstrap-alerts.js', array('jquery'));
	Asset::add('bootstrap-twipsy', 'js/bootstrap-twipsy.js', array('jquery'));
	Asset::add('bootstrap-popover', 'js/bootstrap-popover.js', array('jquery'));
	Asset::add('bootstrap-dropdown', 'js/bootstrap-dropdown.js', array('jquery'));
	Asset::add('bootstrap-scrollspy', 'js/bootstrap-scrollspy.js', array('jquery'));
});

/**
 * Default front-end composer
 */
View::composer('layouts.default', function($view)
{
	$view->with('categories', Category::all());
	Asset::add('style', 'css/bootstrap.css');
	Asset::add('jquery', 'js/jquery.min.js');
	// Asset::add('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js');
	Asset::add('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js', 'jquery');
	Asset::add('jquery-tags', 'js/jquery.tagit.js', array('jquery','jquery-ui'));
	Asset::add('pretty', 'js/google-code-prettify/prettify.js', array('jquery', 'jquery-ui', 'jquery-tags'));
	Asset::add('tools', 'http://cdn.jquerytools.org/1.2.6/form/jquery.tools.min.js', array('jquery'));
	Asset::add('bootstrap-modal', 'js/bootstrap-modal.js', array('jquery'));
	Asset::add('bootstrap-tooltip', 'js/bootstrap-tooltip.js', array('jquery'));
	//Asset::add('bootstrap-alerts', 'js/bootstrap-alerts.js', array('jquery'));
	Asset::add('bootstrap-popover', 'js/bootstrap-popover.js', array('jquery', 'bootstrap-tooltip'));
	Asset::add('bootstrap-dropdown', 'js/bootstrap-dropdown.js', array('jquery'));
	Asset::add('bootstrap-scrollspy', 'js/bootstrap-scrollspy.js', array('jquery'));
	Asset::add('bootstrap-tabs', 'js/bootstrap-tab.js', array('jquery'));
	//Asset::add('bootstrap-buttons', 'js/bootstrap-buttons.js', array('jquery'));
	Asset::add('main', 'js/jquery.main.js', array('jquery', 'jquery-ui', 'jquery-tags'));
});

/**
 * Admin layout composer
 */
View::composer('layouts.admin', function($view)
{
	Asset::add('style', 'css/admin.css');
	Asset::add('jquery', 'js/jquery.min.js');
	// Asset::add('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js');
	Asset::add('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js', 'jquery');
	Asset::add('jquery-tags', 'js/jquery.tagit.js', array('jquery','jquery-ui'));
	Asset::add('pretty', 'js/google-code-prettify/prettify.js', array('jquery', 'jquery-ui', 'jquery-tags'));
	Asset::add('tools', 'http://cdn.jquerytools.org/1.2.6/form/jquery.tools.min.js', array('jquery'));
	Asset::add('bootstrap-modal', 'js/bootstrap-modal.js', array('jquery'));
	Asset::add('bootstrap-tooltip', 'js/bootstrap-tooltip.js', array('jquery'));
	//Asset::add('bootstrap-alerts', 'js/bootstrap-alerts.js', array('jquery'));
	Asset::add('bootstrap-popover', 'js/bootstrap-popover.js', array('jquery', 'bootstrap-tooltip'));
	Asset::add('bootstrap-dropdown', 'js/bootstrap-dropdown.js', array('jquery'));
	Asset::add('bootstrap-scrollspy', 'js/bootstrap-scrollspy.js', array('jquery'));
	Asset::add('bootstrap-tabs', 'js/bootstrap-tab.js', array('jquery'));
	//Asset::add('bootstrap-buttons', 'js/bootstrap-buttons.js', array('jquery'));
	Asset::add('main', 'js/jquery.main.js', array('jquery', 'jquery-ui', 'jquery-tags'));
});

/**
 * Autoloader
 *
 * Tell laravel to autoload models and libraries.
 */
Autoloader::psr(array(
	path('app').'models',
	path('app').'libraries',
));

Autoloader::map(array(
	'Github_helper' => path('app').'libraries/github_helper.php',
	// 'Form' => path('app').'libraries/bootstrap/form.php'
));
