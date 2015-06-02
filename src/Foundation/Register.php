<?php
namespace Iono\Micro\Foundation;

/**
 * Class Register
 * @package Iono\Micro\Foundation
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Register
{

    /** @var string  */
    protected $project = "";

    /** @var array  */
    protected $bootstrap = [

    ];

    /**
     * @param Application $app
     */
    public function register(Application $app)
    {

    }

    public function boot()
    {

    }

    /**
     * @return array
     */
    public function getBootstrap()
    {
        return $this->bootstrap;
    }

}
