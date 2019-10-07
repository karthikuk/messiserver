<?php
namespace Moly\Server\Facades;

use Moly\Server\HandleResponse as Handler;
use Moly\Server\HTTPServer;
use Moly\Server\MServer as Server;

class MServer
{
    public static function __callStatic($name, $arguments)
    {
        return (new Server)->$name(...$arguments);
    }
}
