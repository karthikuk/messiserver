<?php
namespace Moly\Server;

use Moly\Server\Contracts\HandleRequestContract;
use Moly\Server\Request\ServerRequest;
use Moly\Supports\Facades\Request;

class HandleRequest implements HandleRequestContract
{

    protected $_socket;

    protected $_serverRequest = null;

    protected $_serverResponse = null;

    protected $_client = null;

    protected $_callback = null;

 
    public function __construct($socket = null)
    {
        $this->_socket = $this->_socket ?? $socket;
    }


    public function handle(Callable $clientAbstract, $callback = null)
    {
       
        $this->_client = $clientAbstract();

        $this->_callback = $callback;

        $this->makeRequest();

        $this->whatIncoming();

        $this->next();

        return $this;
    }
    

    protected function makeRequest() : HandleRequestContract
    {
        $this->_serverRequest =  !$this->_client->clientBuffer() ?: Request::requestHeaders($this->_client->clientBuffer());

        return $this;
    }

    protected function whatIncoming() : void
    {
        echo  $this->_serverRequest->method() . " " . $this->_serverRequest->header('Host') . $this->_serverRequest->uri() . " \r\n";

        echo $this->_serverRequest->header('Sec-Fetch-User') . "\t". $this->_serverRequest->header('Sec-Fetch-Mode') .  " \r\n";
    }


    public function serverRequest() : ?ServerRequest
    {
        return $this->_serverRequest;
    }

   
    public function next() 
    {
        return $this;
    }

}







