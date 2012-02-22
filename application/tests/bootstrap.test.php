<?php

class BootstrapTest extends PHPUnit_Framework_TestCase {

	/**
	 * Test the Bootstrap::header()
	 *
	 * @group application
	 */
	public function testHeader()
	{
		$this->assertEquals(Bootstrap::header('Test'), '<div class="page-header"><h1>Test</h1></div>');
		$this->assertNull(Bootstrap::header());
	}
}