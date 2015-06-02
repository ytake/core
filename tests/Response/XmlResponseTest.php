<?php

class XmlResponseTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Iono\Micro\Response\XmlResponse  */
    protected $response;

    protected function setUp()
    {
        $this->response = new \Iono\Micro\Response\XmlResponse(
            new \Iono\Micro\Components\Http\FastResponse(
                new \Symfony\Component\HttpFoundation\Response()
            )
        );
    }

    public function testResponse()
    {
        $this->assertInstanceOf("Iono\Micro\Response\XmlResponse", $this->response);
        $this->assertInternalType("array", $this->response->getHeaders());
        $xml = $this->response->response(["testing"]);
        $xmlElement = new \SimpleXMLElement($xml);
        $this->assertSame("result", $xmlElement->getName());
        $this->response->setHeaders(['X-Powered-By' => "testing"]);
        $this->assertArrayHasKey('X-Powered-By', $this->response->getHeaders());
    }

}
