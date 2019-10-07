<?php
namespace Moly\Server\Facades;
use Moly\Server\MessiRouter;

class MRouter
{
    public function __call($name, $arguments)
    {
        return (new MessiRouter)->$name(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
     
        return (new MessiRouter)->getInstance()->$name(...$arguments);
    }
}
