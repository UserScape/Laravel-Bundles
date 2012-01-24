<?php

class GithubTest extends PHPUnit_Framework_TestCase {

	/**
	 * Test the Github_helper::url_exists method.
	 *
	 * @group application
	 */
	public function testUrlExists()
	{
		$this->assertFalse(Github_helper::url_exists('http://laravel.com/doesnotexist'));
	}

	/**
	 * Test the Github_helper::get_file method.
	 *
	 * @group application
	 */
	public function testGetFile()
	{
		// $this->assertType('string', Github_helper::get_file('http://laravel.com/index.php'));
	}

}