<?php
namespace Iono\Micro\Response;

/**
 * Class PhpResponse
 * @package Iono\Micro\Response
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class PhpResponse extends AbstractResponse
{

    /** @var array  */
    protected $headers = [
        "Content-Type" => "text/plain"
    ];

    /**
     * @param array $body
     * @return string
     */
    public function response(array $body)
    {
        return serialize($body);
    }


}
