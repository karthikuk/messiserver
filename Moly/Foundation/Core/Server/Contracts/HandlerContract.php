<?php
namespace Moly\Server\Contracts;



interface HandlerContract
{

    public function handle(Callable $input, $callback);

    public function next(HandlerContract $handler): HandlerContract;
    
}








