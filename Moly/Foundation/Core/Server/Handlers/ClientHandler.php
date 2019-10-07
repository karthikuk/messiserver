<?php
namespace Moly\Server\Handler;

use Moly\Server\Facades\MServer;
use Moly\Server\Facades\Client;
use Moly\Server\Facades\HandleResponse;
use Moly\Supports\Facades\Request;


class ClientHandler extends AbstractServerHandler
{
    protected $_handleClient =  null;

    protected $_socket = null;

    protected $_callback = null;

    public function __construct($socket = null)
    {
        $this->_socket = $this->_socket ?? $socket;
    }

    public function handle(Callable $callable, $callback) 
    {
        $this->_handleClient = Client::accept($this->_socket);

        parent::handle(function() {
            return $this->client();
        },$callback);
    }

    public function client()
    {
        return $this->_handleClient;
    }
}

