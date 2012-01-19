<?php
/**
 * Search controller
 *
 * Allows you to search tags, users, and by keywords
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Controllers
 * @filesource
 */
class Search_Controller extends Controller {

	/**
	 * Tell Laravel we want this class restful. See:
	 * http://laravel.com/docs/start/controllers#restful
	 *
	 * @param bool
	 */
	public $restful = true;


	/**
	 * Search index
	 *
	 * Used by keyword searching.
	 */
	public function get_index()
	{
		$bundles = array();
		$term = '';
		if ($term = strip_tags(Input::get('q')))
		{
			$listings = Listing::where_active('y')->where(function($query)
			{
				$term = strip_tags(Input::get('q'));
				$query->where('title', 'LIKE', '%'.$term.'%');
				$query->or_where('summary', 'LIKE', '%'.$term.'%');
				$query->or_where('description', 'LIKE', '%'.$term.'%');
			});
			$bundles = $listings->paginate(Config::get('application.per_page'));
		}

		return View::make('layouts.default')
			->nest('content', 'category.detail', array(
				'term' => $term,
				'bundles' => $bundles
			));
	}

	/**
	 * Search by a tag
	 *
	 * @param string $item
	 * @return string
	 */
	public function get_tag($item = '')
	{
		// If they didn't give a tag then send them to the advanced search
		if ($item == '')
		{
			return Redirect::to('search');
		}

		$tag = Tag::where_tag($item)->first();
		$model = $tag->bundles();
		// need to reset select clause because eloquent sets select for many to
		// many relationships
		$model->query->selects = null;
		$bundles = $model->where_active('y')->paginate(Config::get('application.per_page'));

		return View::make('layouts.default')
			->nest('content', 'category.detail', array(
				'tag' => $tag,
				'bundles' => $bundles
			));
	}

	/**
	 * Get User
	 *
	 * Find a user by their username and return their listings
	 *
	 * @param string $item - The username
	 * @return string
	 */
	public function get_user($item = '')
	{
		$user = User::where_username($item)->first();

		if ( ! $user)
		{
			return Redirect::to('search');
		}
		$bundles = Listing::where_active('y')->where_user_id($user->id)->paginate(Config::get('application.per_page'));

		return View::make('layouts.default')
			->nest('content', 'category.detail', array(
				'user' => $user,
				'bundles' => $bundles
			));
	}
}