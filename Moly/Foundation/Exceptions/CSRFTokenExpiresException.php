<?php 
namespace Moly\Exceptions;

class CSRFTokenExpiresException extends \Exception
{
    public function __construct($message = null)
    {
        $this->message = $message ? $message : "CSRF Toke Expires";
    }
}