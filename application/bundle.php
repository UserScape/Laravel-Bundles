<?php
View::composer('layouts.default', function($view)
{
	$view->with('categories', Category::all());
	Asset::add('style', 'css/style.css');
	Asset::add('jquery', 'js/jquery.js');
});

Autoloader::map(array(
	'OAuth2' => APP_PATH.'libraries/oauth/OAuth2.php',
	'User' => APP_PATH.'models/user.php',
	'Category' => APP_PATH.'models/category.php',
	'Listing' => APP_PATH.'models/listing.php',
	'Tag' => APP_PATH.'models/tag.php',
));
