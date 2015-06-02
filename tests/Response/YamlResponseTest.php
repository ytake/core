<?php

class YamlResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Iono\Micro\Response\YamlResponse  */
    protected $response;

    protected function setUp()
    {
        $this->response = new \Iono\Micro\Response\YamlResponse(
            new \Iono\Micro\Components\Http\FastResponse(
                new \Symfony\Component\HttpFoundation\Response()
            )
        );
    }

    public function testResponse()
    {
        $this->assertInstanceOf("Iono\Micro\Response\YamlResponse", $this->response);
        $this->assertInternalType("array", $this->response->getHeaders());
        $yaml = $this->response->response(["testing"]);
        $string ="- testing\n";
        $this->assertSame($yaml, $string);
        $this->response->setHeaders(['X-Powered-By' => "testing"]);
        $this->assertArrayHasKey('X-Powered-By', $this->response->getHeaders());
    }

}
