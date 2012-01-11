<?php

class Bundle_Controller extends Controller {

	public function action_index()
	{
		return View::make('layouts.default')
			->nest('content', 'home.index', array('name' => 'Taylor'));
	}

	public function action_add()
	{
		return View::make('layouts.default')
			->nest('content', 'bundles.add', array('name' => 'Taylor'));
	}

	public function action_detail($item)
	{
		$bundle = Listing::find($item)->tags;
		var_dump($bundle);
		return View::make('layouts.default')
			->nest('content', 'bundles.detail', array(
				'bundle' => $bundle
			));
	}
}