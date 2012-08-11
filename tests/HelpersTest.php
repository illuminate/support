<?php

class HelpersTest extends PHPUnit_Framework_TestCase {

	public function testArrayDot()
	{
		$array = array_dot(array('name' => 'taylor', 'languages' => array('php' => true)));
		$this->assertEquals($array, array('name' => 'taylor', 'languages.php' => true));
	}


	public function testArrayGet()
	{
		$array = array('names' => array('developer' => 'taylor'));
		$this->assertEquals('taylor', array_get($array, 'names.developer'));
		$this->assertEquals('dayle', array_get($array, 'names.otherDeveloper', 'dayle'));
		$this->assertEquals('dayle', array_get($array, 'names.otherDeveloper', function() { return 'dayle'; }));
	}


	public function testArraySet()
	{
		$array = array();
		array_set($array, 'names.developer', 'taylor');
		$this->assertEquals('taylor', $array['names']['developer']);
	}


	public function testArrayForget()
	{
		$array = array('names' => array('developer' => 'taylor', 'otherDeveloper' => 'dayle'));
		array_forget($array, 'names.developer');
		$this->assertFalse(isset($array['names']['developer']));
		$this->assertTrue(isset($array['names']['otherDeveloper']));
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