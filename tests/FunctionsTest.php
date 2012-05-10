<?php

class FunctionsTest extends PHPUnit_Framework_TestCase {

	public function testArrayDot()
	{
		Illuminate\Support\Helpers::register();
		$array = array_dot(array('name' => 'taylor', 'languages' => array('php' => true)));
		$this->assertEquals($array, array('name' => 'taylor', 'languages.php' => true));
	}


	public function testStrIs()
	{
		Illuminate\Support\Helpers::register();
		$this->assertTrue(str_is('*.dev', 'localhost.dev'));
		$this->assertTrue(str_is('a', 'a'));
		$this->assertTrue(str_is('*dev*', 'localhost.dev'));
		$this->assertFalse(str_is('*something', 'foobar'));
	}

}