<?php
namespace Iono\Micro\Foundation\Bootstrap;

/**
 * Class ExceptionServiceRegister
 * @package Iono\Micro\Foundation\Bootstrap
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class ExceptionServiceRegister extends AbstractServiceRegister
{

    /**
     * @return void
     */
    public function register()
    {
        $dispatcher = $this->container->getDispatcher();
        $dispatcher->register(function($payload) {
            if($payload['actionType'] === 'exception') {
                if($payload['exception'] instanceof \Exception) {
                    throw $payload['exception'];
                }
            }
        });
    }

}
