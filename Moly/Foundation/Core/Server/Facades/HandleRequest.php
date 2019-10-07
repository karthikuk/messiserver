<?php
namespace Moly\Server\Facades;

use Moly\Server\HandleRequest as Handler;

class HandleRequest
{
    public static function __callStatic($name, $arguments)
    {
     
        return (new Handler)->$name(...$arguments);
    }
}
