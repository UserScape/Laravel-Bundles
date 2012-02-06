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
 */

/**
 * Shared items
 */
$shared = function($view)
{
	$view->with('categories', Category::all());
};

/**
 * Main composers
 */
View::composer('layouts.home', $shared);
View::composer('layouts.default', $shared);
View::composer('error.404', $shared);
View::composer('error.404', function($view)
{
	Asset::add('style', 'css/style.css');
	Asset::add('jquery', 'js/min/jquery-min.js');
	Asset::add('bootstrap', 'js/min/bootstrap-min.js', array('jquery'));
});

/**
 * Autoloader
 *
 * Tell laravel to autoload models and libraries.
 */
Autoloader::psr(array(
	path('app').'models',
	path('app').'libraries'
));

Autoloader::map(array(
	'Github_helper' => path('app').'libraries/github_helper.php',
	'Base_Controller' => path('app').'controllers/base.php',
	'Admin_Base_Controller' => path('app').'controllers/admin/base.php'
));

Bundle::start('github-api');
