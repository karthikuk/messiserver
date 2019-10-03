<?php 
namespace Moly\Exceptions;

class RouteNotFoundException extends \Exception
{
    public function __construct($message = null)
    {
        $this->message = $message ? $message : "Route Not Found";
    }
}