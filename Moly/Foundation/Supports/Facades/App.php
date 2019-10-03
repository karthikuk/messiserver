<?php
namespace Moly\Supports\Facades;

class App {

    public static function __callStatic($name, $arguments)
    {
        return (\Moly\Foundation\Application::getInstance())->$name(...$arguments);
    }
}