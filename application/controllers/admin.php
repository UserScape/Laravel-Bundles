<?php

class Admin_Controller extends Controller {


	public function action_index()
	{
		return View::make('layouts.admin')
			->nest('content', 'admin.index', array(
				'categories' => array(),
			));
	}

}