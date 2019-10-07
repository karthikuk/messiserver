<?php
namespace Moly\Server\Facades;

use Moly\Server\HandleResponse as Handler;
use Moly\Server\HTTPServer;

use Moly\Server\MessiServerConfig as ServerConfig;

class MConfig
{
    public static function __callStatic($name, $arguments)
    {
     
        return (new ServerConfig)->getInstance()->$name(...$arguments);
    }
}
