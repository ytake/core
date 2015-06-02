<?php

class KleinResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Iono\Micro\Components\Http\KleinResponse $response */
    protected $response;
    /** @var  \Iono\Micro\Foundation\Application */
    protected $framework;
    protected function setUp()
    {
        $this->response = new \Iono\Micro\Components\Http\KleinResponse(
            new \Klein\Response()
        );
        $this->framework = (new \Iono\Micro\Foundation\Application())->boot();
    }

    public function testResponseInstance()
    {
        $this->assertInstanceOf("Iono\Micro\Components\Http\KleinResponse", $this->response);
    }

    public function testResponse()
    {
        $action = new StubAction();
        $content = $action(
            new \Iono\Micro\Foundation\Application(),
            "POST",
            []
        );
        $response = $this->response
            ->setAction(
                $content,
                $this->framework
            )
            ->setContent(json_encode(["testing"]))
            ->setStatusCode(200)
            ->setHeader([]);
        $this->assertSame("json", $response->contentType());
        $this->assertInstanceOf("Iono\Micro\Components\Http\KleinResponse", $response);
        ob_start();
        $this->assertInstanceOf("Klein\Response", $response->send());
        ob_end_clean();
    }


    public function testErrorResponse()
    {
        $action = new StubAction();
        $content = $action(
            new \Iono\Micro\Foundation\Application(),
            "GET",
            []
        );
        $response = $this->response
            ->setAction(
                $content,
                $this->framework
            )
            ->setContent(json_encode(["testing"]))
            ->setStatusCode(200)
            ->setHeader([]);
        ob_start();
        $this->assertSame(405, $response->send()->code());
        ob_end_clean();
    }
}

