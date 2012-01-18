<?php
View::composer('layouts.home', function($view)
{
	$view->with('categories', Category::all());
	Asset::add('style', 'css/style.css');
});
View::composer('layouts.default', function($view)
{
	$view->with('categories', Category::all());
	Asset::add('style', 'css/style.css');
	Asset::add('jquery', 'js/jquery.min.js');
	// Asset::add('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js');
	Asset::add('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js', 'jquery');
	Asset::add('pretty', 'js/google-code-prettify/prettify.js', array('jquery', 'jquery-ui', 'jquery-tags'));
	Asset::add('tools', 'js/jquery.tools.js', array('jquery'));
	Asset::add('bootstrap-modal', 'js/bootstrap-modal.js', array('jquery'));
	//Asset::add('bootstrap-alerts', 'js/bootstrap-alerts.js', array('jquery'));
	Asset::add('bootstrap-twipsy', 'js/bootstrap-twipsy.js', array('jquery'));
	Asset::add('bootstrap-popover', 'js/bootstrap-popover.js', array('jquery'));
	Asset::add('bootstrap-dropdown', 'js/bootstrap-dropdown.js', array('jquery'));
	Asset::add('bootstrap-scrollspy', 'js/bootstrap-scrollspy.js', array('jquery'));
	//Asset::add('bootstrap-tabs', 'js/bootstrap-tabs.js', array('jquery'));
	//Asset::add('bootstrap-buttons', 'js/bootstrap-buttons.js', array('jquery'));
	Asset::add('main', 'js/jquery.main.js', array('jquery', 'jquery-ui', 'jquery-tags'));
});

Autoloader::psr(APP_PATH.'models');

Autoloader::map(array(
	'OAuth2' => APP_PATH.'libraries/oauth/OAuth2.php',
	'Gravatar' => APP_PATH.'libraries/gravatar.php',
	'Nav' => APP_PATH.'libraries/nav.php',
));
