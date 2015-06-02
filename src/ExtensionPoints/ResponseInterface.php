<?php
namespace Iono\Micro\ExtensionPoints;

use Illuminate\Container\Container;
use Iono\Micro\Foundation\ActionLayer;

/**
 * Interface ResponseInterface
 * @package Iono\Micro\ExtensionPoints
 */
interface ResponseInterface
{

    /**
     * @param ActionLayer $action
     * @param Container $container
     * @return mixed
     */
    public function setAction(ActionLayer $action, Container $container);

    /**
     * @return mixed
     */
    public function send();

    /**
     * @return mixed
     */
    public function getInstance();
}
