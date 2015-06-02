<?php
namespace Iono\Micro\Foundation\Bootstrap;

use Iono\Micro\Response\ResponseManager;

/**
 * Class ResponseServiceRegister
 * @package Iono\Micro\Foundation\Bootstrap
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class ResponseServiceRegister extends AbstractServiceRegister
{

    /**
     * @return void
     */
    public function register()
    {
        $dispatcher = $this->container->getDispatcher();
        $dispatcher->register(function ($payload) {
            if ($payload['actionType'] === 'response') {
                $this->container->make($payload['response'])
                    ->setAction($payload['action'], $this->container)
                    ->send();
            }
        });
        $this->container->singleton('response.manager', function () {
            return new ResponseManager();
        });
    }

}
