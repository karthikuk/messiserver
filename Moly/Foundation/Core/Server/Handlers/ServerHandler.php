<?php
namespace Moly\Server\Handler;

use Moly\Server\Facades\MServer;
use Moly\Server\Facades\Client;
use Moly\Server\Facades\HandleResponse;
use Moly\Server\MakeClient;
use Moly\Supports\Facades\Request;

class ServerHandler implements ServerHandlerInterface
{

    protected $_socket = null;

    protected $_clientHandler = null;

    protected $_requestHandler = null;

    protected $_responseHandler = null;


    public function __construct($socket = null)
    {
        $this->_socket = $this->_socket ?? $socket;

        $this->createChains();

       
    }

    protected function createChains()
    {
        $this->_clientHandler = new ClientHandler($this->_socket);

        $this->_requestHandler = new ServerRequestHandler($this->_socket);

        $this->_responseHandler = new ServerResponseHandler($this->_socket);

        $this->_clientHandler
            ->next($this->_requestHandler)
            ->next($this->_responseHandler);
           
    }

    public function handle(Callable $callable, $callback = null)
    {
        $this->_clientHandler->handle($callable,  $callback);

        return $this;
    }

    public function clientHandler()
    {
        return $this->_clientHandler;
    }

    public function responseHandler()
    {
        return $this->_responseHandler;
    }

    public function requestHandler()
    {
        return $this->_requestHandler;
    }

    public function client() : MakeClient
    {
        return $this->clientHandler()->client();
    }

    public function response()
    {
        return $this->responseHandler()->serverResponse();
    }

    public function request()
    {
        return $this->requestHandler()->serverRequest();
    }

}






