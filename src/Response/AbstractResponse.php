<?php
namespace Iono\Micro\Response;

use Iono\Micro\ExtensionPoints\ResponseInterface;

/**
 * Class AbstractResponse
 * @package Iono\Micro\Response
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
abstract class AbstractResponse
{

    /** @var ResponseInterface  */
    protected $response;

    /** @var array  */
    protected $headers = [];

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @param array $body
     * @return mixed
     */
    abstract function response(array $body);

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
    }

}
