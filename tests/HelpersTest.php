<?php

class HelpersTest extends PHPUnit_Framework_TestCase {

	public function testArrayDot()
	{
		$array = array_dot(array('name' => 'taylor', 'languages' => array('php' => true)));
		$this->assertEquals($array, array('name' => 'taylor', 'languages.php' => true));
	}


	public function testStrIs()
	{
		$this->assertTrue(str_is('*.dev', 'localhost.dev'));
		$this->assertTrue(str_is('a', 'a'));
		$this->assertTrue(str_is('*dev*', 'localhost.dev'));
		$this->assertFalse(str_is('*something', 'foobar'));
		$this->assertFalse(str_is('foo', 'bar'));
	}


	public function testValue()
	{
		$this->assertEquals('foo', value('foo'));
		$this->assertEquals('foo', value(function() { return 'foo'; }));
	}

}