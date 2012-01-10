<?php

View::composer('layouts.default', function($view)
{
	Asset::add('style', 'css/style.css');
	Asset::add('jquery', 'js/jquery.js');
});

Autoloader::map(array(
	'OAuth2' => APP_PATH.'libraries/oauth/OAuth2.php',
));
