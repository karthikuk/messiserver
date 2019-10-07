<?php
namespace Moly\Server\Contracts;
use Moly\Server\Request\ServerRequest;


interface HandleRequestContract
{

    public function handle(Callable $clientAbstract, $callback);

    public function serverRequest() : ?ServerRequest;
}








