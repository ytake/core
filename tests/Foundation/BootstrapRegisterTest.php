<?php

class BootstrapRegisterTest extends \PHPUnit_Framework_TestCase
{
    /** @var Iono\Micro\Foundation\Application  */
    protected $framework;
    protected function setUp()
    {
        $this->framework = new \Iono\Micro\Foundation\Application;
    }

    public function testDispacher()
    {
        $dispatcher = new \Iono\Micro\Foundation\Bootstrap\DispatcherServiceRegister($this->framework);
        $this->assertNull($dispatcher->register());
        $this->assertInstanceOf("Iono\Dispatcher\Dispatcher", $this->framework['dispatcher']);
    }

    /**
     * @expectedException \Exception
     */
    public function testException()
    {
        $dispatcher = new \Iono\Micro\Foundation\Bootstrap\DispatcherServiceRegister($this->framework);
        $dispatcher->register();
        $exception = new \Iono\Micro\Foundation\Bootstrap\ExceptionServiceRegister($this->framework);
        $this->assertNull($exception->register());
        $this->framework->getDispatcher()->dispatch([
            "actionType" => 'exception',
            "exception" => new \Exception("testing error", 404)
        ]);
    }

    public function testResponse()
    {
        $router = new \Iono\Micro\Foundation\Bootstrap\RouterServiceRegister($this->framework);
        $router->register();
        $dispatcher = new \Iono\Micro\Foundation\Bootstrap\DispatcherServiceRegister($this->framework);
        $dispatcher->register();
        $response = new \Iono\Micro\Foundation\Bootstrap\ResponseServiceRegister($this->framework);
        $this->assertNull($response->register());
        $action = new StubAction();
        $content = $action(
            new \Iono\Micro\Foundation\Application(),
            "POST",
            []
        );
        $this->framework->getDispatcher()->dispatch([
            "actionType" => 'response',
            "response" => \Iono\Micro\Components\Http\FastResponse::class,
            "action" => $content
        ]);
        $this->expectOutputString('{"testing":"testing"}');
    }
}
