<?php
namespace Moly\Server;

use Moly\Server\Contracts\ClientContract;

class MakeClient implements ClientContract
{

    protected $_clientResource = null;

    protected $_clientBuffer = null;

    protected $bufferSize = 65536;

    public function __construct($socket = null, $bufferSize = 65536){}


   

    public function accept($socket) : ClientContract
    {
        $this->_clientResource = stream_socket_accept($socket);

        return $this->receive();
    }

    public function receive() : ClientContract
    {
        $this->_clientBuffer = stream_socket_recvfrom($this->_clientResource, $this->bufferSize);

        return $this;
    }

    
    public function resource()
    {
        return $this->_clientResource;
    }

    public function clientBuffer()
    {
        return $this->_clientBuffer;
    }


}








