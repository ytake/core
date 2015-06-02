<?php

class StandardTest extends \PHPUnit_Framework_TestCase
{
    /** @var StandardStub */
    protected $stub;

    protected $methods = [
        "GET",
        "HEAD",
        "POST",
        "PUT",
        "PATCH",
        "DELETE",
        "OPTIONS"
    ];

    protected function setUp()
    {
        $this->stub = new StandardStub();
    }

    public function testMethod()
    {
        $methods = $this->stub->getMethods();
        $this->assertInternalType("array", $methods);
        $this->assertSame($this->methods, $methods);
    }
}

class StandardStub
{
    use \Iono\Micro\Components\Http\MethodTrait;

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }
}
