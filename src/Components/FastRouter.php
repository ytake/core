<?php
namespace Iono\Micro\Components;

use Iono\Micro\Components\Http\FastResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Iono\Micro\ExtensionPoints\RouterInterface;

/**
 * Class FastRouter
 * @package Iono\Micro\Components
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class FastRouter implements RouterInterface
{

    use Http\MethodTrait, Http\ContainerSetterTrait;

    /** @var array */
    protected $collections = [];

    /** @var string  */
    protected $action;

    /** @var Response  */
    protected $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param $uri
     * @param $callback
     */
    public function router($uri, $callback)
    {
        $this->collections[$uri] = $callback;
    }

    /**
     * @return array
     */
    public function getRouterCollection()
    {
        return $this->collections;
    }

    /**
     * @param Request $http
     * @return void
     */
    public function resolver(Request $http)
    {
        /** @var \FastRoute\Dispatcher $dispatcher */
        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
            foreach ($this->collections as $route => $action) {
                foreach($this->methods as $method) {
                    $r->addRoute($method, $route, $action);
                }
            }
        });
        $this->method = $http->getMethod();
        $this->dispatch($dispatcher->dispatch($this->method, $http->getPathInfo()), $http);
        $this->response();
    }

    /**
     * @return void
     */
    public function response()
    {
        if(!is_null($this->action)) {
            $this->container->getDispatcher()->dispatch([
                "actionType" => 'response',
                "response" => FastResponse::class,
                "action" => $this->action
            ]);
        }
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param array $route
     * @param Request $request
     * @return void
     */
    protected function dispatch(array $route, Request $request)
    {
        switch ($route[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                $this->response->setStatusCode(404)->send();
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $this->response->setStatusCode(405)->send();
                break;
            case \FastRoute\Dispatcher::FOUND:
                $this->params = array_merge($request->query->all(), $route[2]);
                $this->action = $this->content($route[1]);
                break;
        }
    }

    /**
     * @param $string
     * @return mixed
     */
    public function content($string)
    {
        try {
            return $this->getContent($string);
        } catch(\Exception $e) {
            $this->dispatchError($e->getMessage(), 500);
        }
    }

    /**
     * @param $message
     * @param int $code
     */
    protected function dispatchError($message, $code = 404)
    {
        $this->container->getDispatcher()->dispatch([
            "actionType" => 'exception',
            "exception" => new \Exception($message, $code)
        ]);
    }

}
