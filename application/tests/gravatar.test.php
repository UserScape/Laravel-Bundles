<?php

class GravatarTest extends PHPUnit_Framework_TestCase {

	private static $base = 'http://gravatar.com/avatar.php';

	public function testEmailGeneration()
	{
		$this->assertEquals(Gravatar::from_email('john@crepezzi.com'), self::$base . '?gravatar_id=5b480b6a4d63cffb5a6a494ee599333f');
	}

	public function testHashGeneration()
	{
		$this->assertEquals(Gravatar::from_hash('1234'), self::$base . '?gravatar_id=1234');
	}

	public function testWithRating()
	{
		$this->assertEquals(Gravatar::from_hash('1', 'X'), self::$base . '?gravatar_id=1&rating=X');
	}

	public function testWithSize()
	{
		$this->assertEquals(Gravatar::from_hash('1', null, 80), self::$base . '?gravatar_id=1&size=80');
	}

	public function testWithDefault()
	{
		$url = 'http://goo.gl/HOtWh';
		$this->assertEquals(Gravatar::from_hash('1', null, null, $url), self::$base . "?gravatar_id=1&default=$url");
	}

	public function testProfileWithEmail()
	{
		$res = Gravatar::profile_from_email('seejohnrun@gmail.com');
		$this->assertObjectHasAttribute('id', $res);
	}
}