<?php
namespace Moly\Server\Handler;

interface ServerHandlerInterface 
{
    
    public function handle(Callable $callable, $callback);

    public function clientHandler();

    public function requestHandler();

    public function responseHandler();

    public function client();

    public function response();

    public function request();

}