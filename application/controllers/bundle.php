<?php

class Bundle_Controller extends Controller {

	public function action_add()
	{
		return View::make('layouts.default')
			->nest('content', 'bundles.add', array('name' => 'Taylor'));
	}

	public function action_detail($item = '')
	{
		if ($item == '')
		{
			return Response::error('404');
		}

		$bundle = Listing::find($item);
		return View::make('layouts.default')
			->nest('content', 'bundles.detail', array(
				'bundle' => $bundle
			));
	}
}