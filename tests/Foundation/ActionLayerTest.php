<?php

class ActionLayerTest extends \PHPUnit_Framework_TestCase
{
    /** @var StubAction  */
    protected $action;
    protected function setUp()
    {
        $this->action = new StubAction();
    }

    public function testMethodNotAllowedAction()
    {
        $this->assertInstanceOf("Iono\Micro\Foundation\ActionLayer", $this->action);
        $action = $this->action;
        /** @var StubAction $content */
        $content = $action(
            new \Iono\Micro\Foundation\Application(),
            "GET",
            []
        );
        $this->assertInstanceOf("StubAction", $content);
        $this->assertSame(405, $content->getStatusCode());
        $this->assertSame("json", $content->getResourceType());
        $this->assertSame(["X-NAME: testing"], $content->getHeaders());
        $this->assertArrayHasKey('error', $content->getBody());
    }

    public function testAction()
    {
        $action = $this->action;
        /** @var StubAction $content */
        $content = $action(
            new \Iono\Micro\Foundation\Application(),
            "POST",
            []
        );
        $this->assertInstanceOf("StubAction", $content);
        $this->assertInstanceOf("StubRequest", $content->request);
        $this->assertArrayHasKey("testing", $content->getBody());
    }
}

class StubAction extends \Iono\Micro\Foundation\ActionLayer
{
    /** @var array  */
    protected $headers = [
        "X-NAME: testing"
    ];

    public $request;

    /**
     * @param StubRequest $request
     * @return array
     */
    public function post(StubRequest $request)
    {
        $this->request = $request;
        return ["testing" => "testing"];
    }
}

class StubRequest
{

}