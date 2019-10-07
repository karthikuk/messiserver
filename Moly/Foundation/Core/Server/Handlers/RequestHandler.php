<?php
namespace Moly\Server\Handler;

use Moly\Server\Facades\MServer;
use Moly\Server\Facades\Client;
use Moly\Server\Facades\HandleResponse;
use Moly\Server\Facades\HandleRequest;
use Moly\Supports\Facades\Request;


class ServerRequestHandler extends AbstractServerHandler
{

    protected $_socket = null;

    protected $_serverRequest = null;

    protected $_handleRequest = null;

    protected $_client = null;
    
    public function __construct($socket = null)
    {
        $this->_socket = $this->_socket ?? $socket;

    }

    public function handle(Callable $client, $callback) 
    {
        $this->_handleRequest = HandleRequest::handle($client, $callback);

        parent::handle(function() {
            return $this->serverRequest();
        },  $callback);

    }

    public function serverRequest()
    {
        return $this->_handleRequest->serverRequest();
    }
}




