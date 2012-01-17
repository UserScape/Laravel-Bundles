<?php

class Search_Controller extends Controller {

	/**
	 * Tell Laravel we want this class restful. See:
	 * http://laravel.com/docs/start/controllers#restful
	 *
	 * @param bool
	 */
	public $restful = true;


	public function get_index()
	{
		// Show search form.
	}

	/**
	 * Search by a tag
	 *
	 * @param string $tag
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
		$bundles = $model->paginate(1);

		return View::make('layouts.default')
			->nest('content', 'category.detail', array(
				'tag' => $tag,
				'bundles' => $bundles
			));

	}
}