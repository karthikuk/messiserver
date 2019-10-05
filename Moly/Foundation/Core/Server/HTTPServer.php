<?php
namespace Moly\Server;

use Moly\Server\Request\ServerRequest;
use Moly\Server\Response\OutgoingResponse;
use Moly\Supports\Facades\Request;
use Moly\Supports\Facades\Response;

class HTTPServer {

    protected $host = null; 

    protected $port = null;  

    protected $socket = null;  

    protected static $app;

    protected static $router;

    public function __construct($app, $host, $port )
    {
        
        static::$app = $app;

        $this->host = $host;    

        $this->port = (int) $port;


        $this->makingRouter();

        $this->createStreamServer();

        //$this->bindSocket();

       
    }

    
    public function getApp()
    {
        return static::$app;
    }


    protected function makingRouter() 
    {
        static::$router = $this->getApp()->resolve("Moly\Core\Route\Router", true);
    }

    public function getRouter()
    {
        return static::$router;
    }

    
    protected function createStreamServer()  
    {   
       
        $this->socket = stream_socket_server($this->host.":".$this->port, $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN);

      
    }

  
 

    public function listen($callback = null )  
    {


    
        
     
        
        while ($client = stream_socket_accept($this->socket)) {
            
            
            $clientBuffer = stream_socket_recvfrom($client, 65536);
            

            var_dump($clientBuffer);
            $response = "";

            if($clientBuffer)
            {   

                
                $request = Request::requestHeaders( $clientBuffer );
                
               
                echo $request->method() . " " . $request->header('Host') . $request->uri() . " \r\n";
                echo $request->header('Sec-Fetch-User') . "\t". $request->header('Sec-Fetch-Mode') .  " \r\n";
             
               
                if(!is_null($request->header('Sec-Fetch-User')) || $request->header('Sec-Fetch-Mode') == 'cors' || $request->header('Upgrade-Insecure-Requests'))
                {

                    
                    $response = $this->handle($request);

                    $response = call_user_func( $callback,  $request, $response);

                    $response = (string) $response->send();
                }  
                else
                {
                    $response = Response::images()->send();
                    
                }

               
                // if($request->header('Sec-Fetch-Mode') == 'no-cors')
                // {


                    
                // }

                
            }
          
            stream_socket_sendto($client, $response, STREAM_OOB);

            stream_socket_shutdown($client, STREAM_SHUT_WR);

            fclose($client);
    
        }
  
    }


    public function handle(ServerRequest $request)
    {
        $router = $this->getRouter();

        return $router->next($request);
    }
}







