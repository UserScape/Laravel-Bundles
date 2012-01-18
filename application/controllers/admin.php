<?php

class Admin_Controller extends Controller {


	public function action_index()
	{
		$pattern = '#/#';
		$uri = 'test/';
		var_dump(preg_match($pattern, $uri));

		return View::make('layouts.admin')
			->nest('content', 'admin.index', array(
				'categories' => array(),
			));
	}

}