<?php

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Iono\Micro\Foundation\Application */
    protected $framework;

    protected function setUp()
    {
        $this->framework = new \Iono\Micro\Foundation\Application();
    }

    public function testInstance()
    {
        $this->assertInstanceOf("Iono\Micro\Foundation\Application", $this->framework);
    }

    public function testBoot()
    {
        $booted = $this->framework->boot();
        $this->assertInstanceOf("Iono\Micro\Foundation\Application", $booted);
        $this->assertInstanceOf("Iono\Dispatcher\Dispatcher", $booted->getDispatcher());
        $this->assertSame(4, count($booted->getBindings()));
    }

    public function testApplicationBoot()
    {
        $this->framework->boot(new StubApplication());
        $this->expectOutputString("booted");
        // rebind
        $router = $this->framework->make("Iono\Micro\ExtensionPoints\RouterInterface");
        $this->assertInstanceOf("Iono\\Micro\\Components\\KleinRouter", $router);
    }
}

class StubApplication extends \Iono\Micro\Foundation\Register
{

    /** @var array  */
    protected $bootstrap = [
        "StubRouter",
    ];

    public function boot()
    {
        echo "booted";
    }
}

class StubRouter extends \Iono\Micro\Foundation\Bootstrap\AbstractServiceRegister
{
    /**
     * class bind register
     * @return mixed
     */
    public function register()
    {
        $this->container->bind(
            "Iono\Micro\ExtensionPoints\RouterInterface",
            "Iono\\Micro\\Components\\KleinRouter"
        );
    }
}