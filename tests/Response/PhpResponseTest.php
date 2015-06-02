<?php

class PhpResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Iono\Micro\Response\PhpResponse  */
    protected $response;

    protected function setUp()
    {
        $this->response = new \Iono\Micro\Response\PhpResponse(
            new \Iono\Micro\Components\Http\FastResponse(
                new \Symfony\Component\HttpFoundation\Response()
            )
        );
    }

    public function testResponse()
    {
        $this->assertInstanceOf("Iono\Micro\Response\PhpResponse", $this->response);
        $this->assertInternalType("array", $this->response->getHeaders());
        $serialize = $this->response->response(["testing"]);
        $this->assertSame($serialize, serialize(["testing"]));
        $this->response->setHeaders(['X-Powered-By' => "testing"]);
        $this->assertArrayHasKey('X-Powered-By', $this->response->getHeaders());
    }

}
