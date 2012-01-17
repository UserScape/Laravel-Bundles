<?php

class Category_Controller extends Controller {

	public function action_detail($cat = '')
	{
		$category = Category::where_uri($cat)->first();

		$bundles = Listing::where_active('y')->where_category_id($category->id)->paginate(1);

		return View::make('layouts.default')
			->nest('content', 'category.detail', array(
				'category' => $category,
				'bundles' => $bundles
			));
	}
}
