<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @version  3.0.0
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 * @link     http://laravel.com
 */

// --------------------------------------------------------------
// Tick... Tock... Tick... Tock...
// --------------------------------------------------------------
define('LARAVEL_START', microtime(true));

$host = $_SERVER['HTTP_HOST'];
if ($host == 'laravel-bundles.dev' OR strpos($host, 'localhost') !== FALSE)
{
	$_SERVER['LARAVEL_ENV'] = 'local';
}
elseif ($host == 'bundles.laravel.com')
{
	$_SERVER['LARAVEL_ENV'] = 'production';
}
else
{
	$_SERVER['LARAVEL_ENV'] = 'staging';
}

// --------------------------------------------------------------
// Indicate that the request is from the web.
// --------------------------------------------------------------
$web = true;

// --------------------------------------------------------------
// Set the core Laravel path constants.
// --------------------------------------------------------------
require '../paths.php';

// --------------------------------------------------------------
// Unset the temporary web variable.
// --------------------------------------------------------------
unset($web);

// --------------------------------------------------------------
// Launch Laravel.
// --------------------------------------------------------------
require path('sys').'laravel.php';
