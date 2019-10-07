<?php
namespace Moly\Server\Handler;

use Moly\Server\Contracts\HandlerContract;

abstract class AbstractServerHandler implements HandlerContract
{


    protected $nextHandler = null;

    public function next(HandlerContract $handler): HandlerContract
    {
        return $this->nextHandler =  $handler;
    }

    public function handle(Callable $callable, $callback)
    {
        if ($this->nextHandler) 
        {
            return $this->nextHandler->handle($callable, $callback);
        }
        
        return null;
    }

    

}







