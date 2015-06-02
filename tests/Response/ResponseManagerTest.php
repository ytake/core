<?php

class ResponseManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Iono\Micro\Response\ResponseManager */
    protected $manager;
    /** @var \Iono\Micro\Foundation\Application */
    protected $app;
    /** @var \Iono\Micro\Components\FastRouter */
    protected $router;

    protected function setUp()
    {
        $this->router = new \Iono\Micro\Components\FastRouter(
            new \Symfony\Component\HttpFoundation\Response()
        );
        $this->app = (new \Iono\Micro\Foundation\Application())->boot();
        $this->router->setContainer($this->app);
        $this->router->router("/", "AcmeAction");
    }

    public function testXmlResponse()
    {
        $action = new AcmeAction();
        /** @var StubAction $content */
        $content = $action(
            $this->app,
            "GET",
            []
        );
        $this->assertInstanceOf("AcmeAction", $content);
        $this->assertSame(200, $content->getStatusCode());
        $this->assertSame("xml", $content->getResourceType());
        $requestClient = \Symfony\Component\HttpFoundation\Request::createFromGlobals()->create("/", "get");
        $this->router->resolver($requestClient);
    }

    public function testPhpResponse()
    {
        $action = new AcmeAction();
        /** @var StubAction $content */
        $content = $action(
            $this->app,
            "POST",
            []
        );
        $this->assertInstanceOf("AcmeAction", $content);
        $this->assertSame(200, $content->getStatusCode());
        $this->assertSame("php", $content->getResourceType());
        $requestClient = \Symfony\Component\HttpFoundation\Request::createFromGlobals()->create("/", "post");
        $this->router->resolver($requestClient);
    }

    public function testYamlResponse()
    {
        $action = new AcmeAction();
        /** @var StubAction $content */
        $content = $action(
            $this->app,
            "PUT",
            []
        );
        $this->assertInstanceOf("AcmeAction", $content);
        $this->assertSame(200, $content->getStatusCode());
        $this->assertSame("yaml", $content->getResourceType());
        $requestClient = \Symfony\Component\HttpFoundation\Request::createFromGlobals()->create("/", "put");
        $this->router->resolver($requestClient);
    }

    public function testCustomResponse()
    {
        $this->app['response.manager']->addResponse('custom', function () {
            return new CustomResponse(
                new \Iono\Micro\Components\Http\FastResponse(
                    new \Symfony\Component\HttpFoundation\Response()
                )
            );
        });
        $action = new AcmeAction();
        /** @var StubAction $content */
        $content = $action(
            $this->app,
            "DELETE",
            []
        );
        $this->assertInstanceOf("AcmeAction", $content);
        $this->assertSame(200, $content->getStatusCode());
        $this->assertSame("custom", $content->getResourceType());
        $requestClient = \Symfony\Component\HttpFoundation\Request::createFromGlobals()->create("/", "delete");
        $this->router->resolver($requestClient);
    }

    /**
     * no content data
     * @expectedException \LogicException
     */
    public function testError()
    {
        $action = new AcmeAction();
        /** @var StubAction $content */
        $content = $action(
            $this->app,
            "HEAD",
            []
        );
        $this->assertInstanceOf("AcmeAction", $content);
        $this->assertSame(200, $content->getStatusCode());
        $this->assertSame("custom2", $content->getResourceType());
        $requestClient = \Symfony\Component\HttpFoundation\Request::createFromGlobals()->create("/", "head");
        $this->router->resolver($requestClient);
    }
}

class CustomResponse extends \Iono\Micro\Response\AbstractResponse
{
    /** @var array */
    protected $headers = [
        "X-Powered-By" => "ApplicationName.Client"
    ];

    /**
     * @param array $body
     * @return mixed
     */
    function response(array $body)
    {
        return 'custom';
    }

}

class AcmeAction extends \Iono\Micro\Foundation\ActionLayer
{
    /** @var string */
    protected $resource = "xml";

    /**
     * @return array
     */
    public function get()
    {
        return ["testing" => "testing"];
    }

    /**
     * @return array
     */
    public function post()
    {
        $this->resource = "php";
        return ["testing" => "testing"];
    }

    /**
     * @return array
     */
    public function put()
    {
        $this->resource = "yaml";
        return ["testing" => "testing"];
    }

    /**
     * @return array
     */
    public function delete()
    {
        $this->resource = "custom";
        return ["testing" => "testing"];
    }

    public function head()
    {
        $this->resource = "custom2";
        return ["testing" => "testing"];
    }
}

