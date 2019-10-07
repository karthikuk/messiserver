<?php
namespace Moly\Server\Contracts;



interface ClientContract
{

    public function resource();


    public function accept($socket):ClientContract;


    public function receive():ClientContract;
    

    public function clientBuffer();
}








