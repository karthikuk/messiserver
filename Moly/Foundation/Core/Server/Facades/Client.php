<?php
namespace Moly\Server\Facades;

use Moly\Server\MakeClient;

class Client
{
    public static function __callStatic($name, $arguments)
    {
        return (new MakeClient)->$name(...$arguments);
    }
}
