<?php
namespace Moly\Server;

use Moly\Server\Request\ServerRequest;
use Moly\Server\Response\OutgoingResponse;
use Moly\Supports\Facades\Request;
use Moly\Supports\Facades\Response;

class MessiServer extends MServer
{

    protected $host = null; 

    protected $port = null;  

    protected $socket = null;  

    protected static $app;

    protected static $router;

    public function __construct($app, $host, $port)
    {
        
        $this->messiApplication($app);

        $this->host = $host;    

        $this->port = (int) $port;

        $this->createStreamServer();
    }

    

    
    protected function createStreamServer()  
    {   
        $this->socket = stream_socket_server("tcp://".$this->host.":".$this->port, $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN);

        fputs(STDOUT, "Waiting for connections...\n");
    }

  
    public function listen($callback = null )  
    {

        while (true) {
            $this->requestHandlers($callback);
        }

       fclose($this->socket);
  
    }
}







