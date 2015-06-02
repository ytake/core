<?php
namespace Iono\Micro\Components;

use Klein\Klein;
use Iono\Micro\Components\Http\KleinResponse;
use Symfony\Component\HttpFoundation\Request;
use Iono\Micro\ExtensionPoints\RouterInterface;

/**
 * Class KleinRouter
 * @package Iono\Micro\Foundation\Components
 */
class KleinRouter implements RouterInterface
{

    use Http\ContainerSetterTrait;

    /** @var Klein */
    protected $router;

    /** @var array */
    protected $collections = [];

    /** @var string  */
    protected $action;

    /**
     * @param Klein $router
     */
    public function __construct(Klein $router)
    {
        $this->router = $router;
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
     * @return string|void
     */
    public function resolver(Request $http)
    {
        if (!count($this->collections)) {
            $this->dispatchError("router not found", 404);
        }
        foreach ($this->collections as $route => $action) {
            $this->router->respond($http->getMethod(), $route,
                function (\Klein\Request $request) use ($action) {
                    $this->method = $request->method();
                    $this->params = array_merge(
                        $request->paramsGet()->all(),
                        $request->paramsPost()->all(),
                        $request->paramsNamed()->all()
                    );
                    $this->action = $this->content($action);
                    $this->response();
                });
        }
        $this->errorHandler();
        $this->router->dispatch();
    }

    /**
     * @return void
     */
    protected function errorHandler()
    {
        $this->router->onHttpError(function($code, Klein $router) {
            $router->response()->code($code);
        });
    }

    /**
     * @return \Klein\Response
     */
    public function getResponse()
    {
        return $this->router->response();
    }

    /**
     * response dispatch
     */
    public function response()
    {
        $this->container->getDispatcher()->dispatch([
            "actionType" => 'response',
            "response" => KleinResponse::class,
            "action" => $this->action,
        ]);
    }


    /**
     * @param $string
     * @return mixed
     * @throws \Exception
     */
    public function content($string)
    {
        try {
            return $this->getContent($string);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), 500);
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
