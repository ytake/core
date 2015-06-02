<?php

class FastRouterTest extends \PHPUnit_Framework_TestCase
{

    /** @var \Iono\Micro\Components\FastRouter */
    protected $router;
    /** @var \Iono\Micro\Foundation\Application  */
    protected $app;
    protected function setUp()
    {
        $this->router = new \Iono\Micro\Components\FastRouter(
            new \Symfony\Component\HttpFoundation\Response()
        );
        $this->app = (new \Iono\Micro\Foundation\Application())->boot();
        $this->router->setContainer($this->app);
    }

    public function testInstance()
    {
        $this->assertInstanceOf("Iono\Micro\Components\FastRouter", $this->router);
    }

    /**
     * no content data
     * @expectedException \Exception
     */
    public function testErrorContent()
    {
        $this->router->content("StubAction");
    }

    public function testSuccessContent()
    {
        $this->router->router("/", "StubAction");
        $this->assertArrayHasKey("/", $this->router->getRouterCollection());
        $requestClient = \Symfony\Component\HttpFoundation\Request::createFromGlobals()->create("/", "post");
        $this->router->resolver($requestClient);
        $this->expectOutputString('{"testing":"testing"}');

    }

    public function testNotAllowedRequest()
    {
        $this->router->router("/", "StubAction");
        $requestClient = \Symfony\Component\HttpFoundation\Request::createFromGlobals()->create("/", "get");
        $this->router->resolver($requestClient);
        $this->expectOutputString('{"error":"Method Not Allowed"}');
    }

    public function testNotFoundRequest()
    {
        $requestClient = \Symfony\Component\HttpFoundation\Request::createFromGlobals()->create("/", "get");
        $this->router->resolver($requestClient);

        $this->assertSame(404, $this->router->getResponse()->getStatusCode());
    }

    /**
     * @param $class
     * @param $name
     * @return \ReflectionProperty
     */
    protected function getProtectProperty($class, $name)
    {
        $class = new \ReflectionClass($class);
        $property = $class->getProperty($name);
        $property->setAccessible(true);
        return $property;
    }

}
