<?php
View::composer('layouts.default', function($view)
{
	$view->with('categories', Category::all());
	Asset::add('style', 'css/style.css');
	Asset::add('jquery', 'js/jquery.min.js');
	// Asset::add('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js');
	Asset::add('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js', 'jquery');
	Asset::add('main', 'js/jquery.main.js', array('jquery', 'jquery-ui', 'jquery-tags'));
});

Autoloader::psr(APP_PATH.'models');

Autoloader::map(array(
	'OAuth2' => APP_PATH.'libraries/oauth/OAuth2.php',
));
