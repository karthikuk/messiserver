<?php
namespace Moly\Supports\Facades;
use  Moly\Server\Response\OutgoingResponse;


class Response {

  

    public function __call($name, $arguments)
    {
        
        return (new OutgoingResponse)->$name(...$arguments);
    }
    
    public static function __callStatic($name, $arguments)
    {
        return (new OutgoingResponse)->$name(...$arguments);
    }
}