<?php
namespace Moly\Server\Contracts;



interface HandleResponseContract
{

    public function handle(Callable $clientAbstract, $callback);

    public function serverResponse();

    public function serverRequest();

    public function next() : string;
}








