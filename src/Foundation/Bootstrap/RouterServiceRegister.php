<?php
namespace Iono\Micro\Foundation\Bootstrap;

/**
 * Class RouterServiceRegister
 * @package Iono\Micro\Foundation\Bootstrap
 */
class RouterServiceRegister extends AbstractServiceRegister
{

    /**
     * @return void
     */
    public function register()
    {
        $this->container->bind(
            "Iono\\Micro\\ExtensionPoints\\RouterInterface",
            "Iono\\Micro\\Components\\FastRouter"
        );
    }

}
