<?php
namespace Iono\Micro\Components\Http;

use Illuminate\Container\Container;

/**
 * Class ContainerSetterTrait
 * @package Iono\Micro\Components\Http
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
trait ContainerSetterTrait
{

    /** @var Container */
    protected $container;

    /** @var string  */
    protected $method;

    /** @var array  */
    protected $params;

    /**
     * @param Container $container
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @param $string
     * @return mixed
     */
    public function getContent($string)
    {
        return $this->container
            ->make($string)
            ->__invoke(
                $this->container,
                $this->method,
                $this->params
            );
    }
}
