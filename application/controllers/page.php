<?php
/**
 * Page controller
 *
 * Responsible for building the page details.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Page_Controller extends Base_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Page Detail
	 *
	 * Pulls the page from the db and throws it into a generic view
	 *
	 * @param string $uri
	 * @return string
	 */
	public function action_detail($uri = '')
	{
		if ( ! $page = Page::where_uri($uri)->first())
		{
			return Response::error('404');
		}

		return View::make('layouts.default')
			->nest('content', 'page.details', array(
				'page' => $page,
			));
	}
}