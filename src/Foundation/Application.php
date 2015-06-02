<?php
namespace Iono\Micro\Foundation;

use Iono\Dispatcher\Dispatcher;
use Illuminate\Container\Container;

/**
 * Class Application
 * @package Iono\Micro\Foundation
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Application extends Container
{

    /** @var string  dispatcher event name */
    protected $prefix = "iono.framework";

    /** @var Dispatcher  */
    protected $dispatcher;

    /** @var array  */
    protected $bootstrap = [
        "Iono\\Micro\\Foundation\\Bootstrap\\DispatcherServiceRegister",
        "Iono\\Micro\\Foundation\\Bootstrap\\RouterServiceRegister",
        "Iono\\Micro\\Foundation\\Bootstrap\\ExceptionServiceRegister",
        "Iono\\Micro\\Foundation\\Bootstrap\\ResponseServiceRegister",
        "Iono\\Micro\\Foundation\\Bootstrap\\LoggerServiceRegister"
    ];

    /**
     * @param Register $register
     * @return $this
     */
    public function boot(Register $register = null)
    {
        $this->registerBootstrap($this->bootstrap);
        $this->getDispatcher()->setPrefix($this->prefix);

        if($register instanceof Register) {
            $this->registerProject($register);
        }
        // dispatch boot event
        $this->getDispatcher()->dispatch([
            "actionType" => 'boot',
        ]);
        return $this;
    }

    /**
     * @return Dispatcher
     */
    public function getDispatcher()
    {
        return $this['dispatcher'];
    }

    /**
     * @param Register $register
     * @return void
     */
    public function registerProject(Register $register)
    {
        $this->registerBootstrap($register->getBootstrap());
        $register->register($this);

        $this->getDispatcher()->register(function () use ($register) {
            $register->boot();
        });

    }

    /**
     * @param array $bootstraps
     * @return void
     */
    protected function registerBootstrap(array $bootstraps)
    {
        if(count($bootstraps)) {
            foreach ($bootstraps as $bootstrap) {
                call_user_func_array([new $bootstrap($this), 'register'], [$this]);
            }
        }
    }

}
