<?php

class FacadeTest extends PHPUnit_Framework_TestCase {

	public function testFacadeCallsUnderlyingApplication()
	{
		FacadeStub::setFacadeApplication(array('foo' => new ApplicationStub));
		$this->assertEquals('baz', FacadeStub::bar());
	}

    public function testCanGetResolvedInstance()
    {
        FacadeStub::setFacadeApplication(array('foo' => new ApplicationStub));

        $this->assertInstanceOf('ApplicationStub', FacadeStub::getResolvedInstance('foo'));

        $this->assertArrayHasKey('foo', FacadeStub::getResolvedInstance());
    }

    public function testCanRemoveResolvedInstance()
    {
        FacadeStub::setFacadeApplication(array('foo' => new ApplicationStub));
        FacadeStub::setFacadeApplication(array('bar' => new ApplicationStub));

        FacadeStub::removeResolvedInstance('foo');

        $this->assertArrayNotHasKey('foo', FacadeStub::getResolvedInstance());

        FacadeStub::removeResolvedInstance();

        $this->assertEmpty(FacadeStub::getResolvedInstance());
    }

}

class FacadeStub extends Illuminate\Support\Facades\Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'foo';
	}

}

class ApplicationStub {

	public function bar()
	{
		return 'baz';
	}

}
