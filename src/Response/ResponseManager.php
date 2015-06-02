<?php
namespace Iono\Micro\Response;

use Iono\Micro\Foundation\ActionLayer;
use Iono\Micro\ExtensionPoints\ResponseInterface;

/**
 * Class ResponseManager
 * @package Iono\Micro\Response
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class ResponseManager
{

    /** @var array  */
    public $headers = [];

    /** @var   */
    public $body;

    /** @var string  */
    public $contentType;

    /** @var int  */
    public $statusCode = 200;

    /** @var ResponseInterface */
    protected $response;

    /** @var array  */
    protected $callback = [];

    /**
     * @param ResponseInterface $response
     * @return $this
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @param ActionLayer $action
     * @return $this
     */
    public function resource(ActionLayer $action)
    {
        $responseType = mb_strtolower($action->getResourceType()) . "Response";
        $this->contentType = $action->getResourceType();
        $this->statusCode = $action->getStatusCode();
        $this->$responseType($action);
        return $this;
    }

    /**
     * @param $responseClass
     * @param callable $callback
     */
    public function addResponse($responseClass, callable $callback)
    {
        $this->callback[$responseClass . "Response"] = $callback;
    }

    /**
     * @param ActionLayer $action
     */
    protected function jsonResponse(ActionLayer $action)
    {
        $this->setContent($action, new JsonResponse($this->response));
    }

    /**
     * @param ActionLayer $action
     */
    protected function xmlResponse(ActionLayer $action)
    {
        $this->setContent($action, new XmlResponse($this->response));
    }

    /**
     * @param ActionLayer $action
     */
    protected function phpResponse(ActionLayer $action)
    {
        $this->setContent($action, new PhpResponse($this->response));
    }

    /**
     * @param ActionLayer $action
     */
    protected function yamlResponse(ActionLayer $action)
    {
        $this->setContent($action, new YamlResponse($this->response));
    }

    /**
     * @param ActionLayer $action
     * @param AbstractResponse $response
     */
    protected function setContent(ActionLayer $action, AbstractResponse $response)
    {
        $response->setHeaders($action->getHeaders());
        $this->headers = $response->getHeaders();
        $this->body = $response->response($action->getBody());
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        if(!isset($this->callback[$name])) {
            throw new \LogicException("not found, [{$name}]response class", 500);
        }
        $this->setContent($arguments[0], call_user_func($this->callback[$name], [$this->response]));
    }

}
