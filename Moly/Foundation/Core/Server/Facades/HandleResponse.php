<?php
namespace Moly\Server\Facades;

use Moly\Server\HandleResponse as Handler;

class HandleResponse
{
    public static function __callStatic($name, $arguments)
    {
     
        return (new Handler)->$name(...$arguments);
    }
}
