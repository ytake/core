<?php
namespace Iono\Micro\Foundation;

/**
 * Class ActionLayer
 * @package Iono\Micro\Foundation
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
abstract class ActionLayer
{

    /** @var Application */
    protected $app;

    /** @var   */
    protected $body;

    /** @var string  */
    protected $resource = "json";

    /** @var array  */
    protected $parameters;

    /** @var array  */
    protected $headers = [];

    /** @var int  */
    protected $statusCode = 200;

    /**
     * @param Application $container
     * @param $method
     * @param array $parameters
     * @return $this
     */
    public function __invoke(Application $container, $method, array $parameters)
    {
        $method = strtolower($method);
        $this->app = $container;
        if(method_exists($this, $method)) {
            $this->parameters = (object) $parameters;
            $this->body = $this->app->call([$this, $method]);
            return $this;
        }

        $this->body = ["error" => "Method Not Allowed"];
        $this->statusCode = 405;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getResourceType()
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * return status code
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

}
