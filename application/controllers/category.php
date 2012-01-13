<?php

class Category_Controller extends Controller {

	public function action_detail($cat = '')
	{
		$category = Category::find($cat);
		$bundles = $category->bundles()->paginate(1);

		// var_dump(Laravel\Database\Connection::$queries);

		return View::make('layouts.default')
			->nest('content', 'category.detail', array(
				'category' => $category,
				'bundles' => $bundles
			));
	}
}
