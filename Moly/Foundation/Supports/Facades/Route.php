<?php
namespace Moly\Supports\Facades;



class Route {

    public static function __callStatic($name, $arguments)
    {
        return (App::resolve("Moly\Core\Route\Router", true))->$name(...$arguments);
    }
}