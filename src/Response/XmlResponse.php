<?php
namespace Iono\Micro\Response;

/**
 * Class YamlResponse
 * @package Iono\Micro\Response
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class XmlResponse extends AbstractResponse
{

    /** @var array  */
    protected $headers = [
        "Content-Type" => "application/xml"
    ];

    /**
     * @param array $body
     * @return string
     */
    public function response(array $body)
    {
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        return $serializer->serialize($body, 'xml');
    }


}
