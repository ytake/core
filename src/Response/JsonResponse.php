<?php
namespace Iono\Micro\Response;

/**
 * Class JsonResponse
 * @package Iono\Micro\Response
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class JsonResponse extends AbstractResponse
{

    /** @var array  */
    protected $headers = [
        "Content-Type" => "application/json"
    ];

    /**
     * @param array $body
     * @return string
     */
    public function response(array $body)
    {
        return json_encode($body);
    }

}
