<?php
namespace Iono\Micro\Components\Http;

/**
 * Class MethodTrait
 * @package Iono\Micro\Components\Http
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
trait MethodTrait
{

    /**
     * @var array
     */
    protected $methods = [
        "GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"
    ];

}
