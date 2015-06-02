<?php
namespace Iono\Micro\Foundation\Bootstrap;

use Iono\Dispatcher\Dispatcher;

/**
 * Class DispatcherServiceRegister
 * @package Iono\Micro\Foundation\Bootstrap
 */
class DispatcherServiceRegister extends AbstractServiceRegister
{

    /**
     * @return void
     */
    public function register()
    {
        $this->container->bindShared('dispatcher', function () {
            return new Dispatcher();
        });
    }

}
