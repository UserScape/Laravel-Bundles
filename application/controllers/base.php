<?php
/**
 * Bundles controller
 *
 * This is used for basic bundle crud operations as well as
 * displaying the bundle details page.
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