<?php
namespace Iono\Micro\Foundation\Bootstrap;

use Iono\Micro\Foundation\Application;

/**
 * Class AbstractRegister
 * @package Iono\Micro\Foundation\Bootstrap
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
abstract class AbstractServiceRegister
{

    /** @var Application  */
    protected $container;

    /**
     * @param Application $container
     */
    public function __construct(Application $container)
    {
        $this->container = $container;
    }

    /**
     * class bind register
     * @return mixed
     */
    abstract public function register();

}
