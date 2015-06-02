<?php
namespace Iono\Micro\ExtensionPoints;

/**
 * Class RouterInterface
 * @package Iono\Micro\Foundation\ExtensionPoints
 */
interface RouterInterface
{

    /**
     * @param $uri
     * @param $callback
     */
    public function router($uri, $callback);

    /**
     * @param \Symfony\Component\HttpFoundation\Request $http
     * @return mixed
     */
    public function resolver(\Symfony\Component\HttpFoundation\Request $http);

}
