<?php
/**
 * Bootstrap
 *
 * A library to help with some common bootstrap setup
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Libraries
 * @filesource
 */
class Bootstrap {

	/**
	 * Header
	 *
	 * Build the html for a common bootstrap header
	 *
	 * @param string $text
	 * @return string
	 */
	public static function header($text = '')
	{
		return '<div class="page-header"><h1>'.$text.'</h1></div>';
	}

}