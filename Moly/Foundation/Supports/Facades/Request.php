<?php
namespace Moly\Supports\Facades;



class Request {

  

    public function __call($name, $arguments)
    {
        return (App::resolve('request', true))->$name(...$arguments);
    }
    
    public static function __callStatic($name, $arguments)
    {
        return (App::resolve('request', true))->$name(...$arguments);
    }
}