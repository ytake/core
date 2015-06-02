<?php
namespace __Tests\Foundation;

class RegisterTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Iono\Micro\Foundation\Register  */
    protected $register;

    protected function setUp()
    {
        $this->register = new \Iono\Micro\Foundation\Register();
    }

    public function testInstance()
    {
        $this->assertInstanceOf("Iono\Micro\Foundation\Register", $this->register);
    }

    public function testRegister()
    {
        $this->assertNull($this->register->register(new \Iono\Micro\Foundation\Application));
        $this->assertNull($this->register->boot());
        $this->assertInternalType('array', $this->register->getBootstrap());
    }

}
