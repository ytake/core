<?php
namespace Iono\Micro\Foundation\Bootstrap;

/**
 * Class LoggerServiceRegister
 * @package Iono\Micro\Foundation\Bootstrap
 */
class LoggerServiceRegister extends AbstractServiceRegister
{


    /**
     * class bind register
     * @return mixed
     */
    public function register()
    {
        $this->container->bind(
            "Psr\Log\LoggerInterface",
            "Monolog\Logger"
        );
    }

}
