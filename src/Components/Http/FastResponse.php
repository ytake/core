<?php
namespace Iono\Micro\Components\Http;

use Illuminate\Container\Container;
use Iono\Micro\Foundation\ActionLayer;
use Iono\Micro\Response\ResponseManager;
use Symfony\Component\HttpFoundation\Response;
use Iono\Micro\ExtensionPoints\ResponseInterface;

/**
 * Class FastResponse
 * @package Iono\Micro\Components\Http
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class FastResponse implements ResponseInterface
{

    /** @var Response  */
    protected $response;

    /** @var ActionLayer  */
    protected $action;

    /** @var ResponseManager  */
    protected $resource;

    /** @var int  */
    protected $statusCode = 200;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param ActionLayer $action
     * @param Container $container
     * @return $this
     */
    public function setAction(ActionLayer $action, Container $container)
    {
        $this->action = $action;
        $this->resource = $container['response.manager']->setResponse($this)->resource($action);
        return $this;
    }

    /**
     * @param array $body
     * @return $this
     */
    public function setContent($body = null)
    {
        $this->resource->body = (is_null($body)) ? $this->resource->body : $body;
        $this->response->setContent($this->resource->body);
        return $this;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeader(array $headers = [])
    {
        $this->addHeaders($this->resource->headers);
        $this->addHeaders($headers);
        return $this;
    }

    /**
     * @param null $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode = null)
    {
        $statusCode = (is_null($statusCode)) ? $this->resource->statusCode : $statusCode;
        $this->response->setStatusCode($statusCode);
        return $this;
    }

    /**
     * @param array $headers
     */
    protected function addHeaders(array $headers = [])
    {
        if(count($headers)) {
            foreach($headers as $content => $header) {
                $this->response->headers->set($content, $header);
            }
        }
    }

    /**
     * @return $this
     */
    public function setCookie()
    {
        //
        return $this;
    }

    /**
     * @return string
     */
    public function contentType()
    {
        return $this->resource->contentType;
    }

    /**
     * @return Response
     */
    public function send()
    {
        $this->setContent()
            ->setStatusCode()
            ->setHeader()
            ->setCookie();
        return $this->response->send();
    }

    /**
     * @return Response
     */
    public function getInstance()
    {
        return $this->response;
    }

}
