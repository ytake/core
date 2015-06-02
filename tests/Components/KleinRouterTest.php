<?php

class KleinRouterTest extends \PHPUnit_Framework_TestCase
{

    /** @var \Iono\Micro\Components\KleinRouter */
    protected $router;
    /** @var \Iono\Micro\Foundation\Application  */
    protected $app;
    protected function setUp()
    {
        $this->router = new \Iono\Micro\Components\KleinRouter(
            new \Klein\Klein()
        );
        $this->app = (new \Iono\Micro\Foundation\Application())->boot();
        $this->router->setContainer($this->app);
    }

    public function testInstance()
    {
        $this->assertInstanceOf("Iono\Micro\Components\KleinRouter", $this->router);
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
    }

    public function testNotAllowedRequest()
    {
        $this->router->router("/", "StubAction");
        $requestClient = \Symfony\Component\HttpFoundation\Request::createFromGlobals()->create("/", "get");
        $this->router->resolver($requestClient);
        $this->expectOutputString('{"error":"Method Not Allowed"}');
    }

    /**
     * no content data
     * @expectedException \Exception
     */
    public function testNotFoundRequest()
    {
        $requestClient = \Symfony\Component\HttpFoundation\Request::createFromGlobals()->create("/", "get");
        $this->router->resolver($requestClient);
    }

}
