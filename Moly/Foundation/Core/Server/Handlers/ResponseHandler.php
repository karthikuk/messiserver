<?php
namespace Moly\Server\Handler;

use Moly\Server\Facades\MServer;
use Moly\Server\Facades\Client;
use Moly\Server\Facades\HandleResponse;
use Moly\Supports\Facades\Request;

class ServerResponseHandler extends AbstractServerHandler
{

    protected $_socket = null;

    protected $_serverRequest = null;

    protected $_serverResponse = null;

    protected $_handleResponse = null;
    
    public function __construct($socket = null)
    {
        $this->_socket = $this->_socket ?? $socket;

    }

    public function handle(Callable $request, $callback )
    {
        $this->_handleResponse = HandleResponse::handle($request, $callback);
    }

    public function serverRequest()
    {
        return $this->_handleResponse->serverRequest();
    }

    public function serverResponse()
    {
        return $this->_handleResponse->serverResponse();
    }
}



