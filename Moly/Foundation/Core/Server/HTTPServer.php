<?php
namespace Moly\Server;

use Moly\Server\Request\ServerRequest;
use Moly\Server\Response\OutgoingResponse;
use Moly\Supports\Facades\Request;

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
        // $opts = array('http' =>
        //         array(
        //             'method'  => 'POST',
        //             'header'  => 'Content-type: application/x-www-form-urlencoded'
        //         )
        //     );
          
        // $context = stream_context_get_default ($opts);

    

       
        $this->socket = stream_socket_server($this->host.":".$this->port, $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN);

        stream_set_blocking($this->socket, true);
    }

  
 

    public function listen($callback = null )  
    {


      

        
        
        while ($client = stream_socket_accept($this->socket)) {
            
            
         


            $clientBuffer = stream_socket_recvfrom($client, 65536);
            
           

          
         
            var_dump($clientBuffer);
            print_r(stream_get_meta_data($client));
            //var_dump($contents);
        
            
            // $fp = fsockopen($this->host, $this->port, $errno, $errstr, 30);
            // if (!$fp) {
            //     echo "$errstr ($errno)<br />\n";
            // } else {
            //     $out = "GET / HTTP/1.1\r\n";
            //     $out .= "Host: www.example.com\r\n";
            //     $out .= "Connection: Close\r\n\r\n";
            //     fwrite($fp, $out);
            //     while (!feof($fp)) {
            //         echo fgets($fp, 128);
            //     }
            //     fclose($fp);
            // }

           
            $response = "";

            if($clientBuffer)
            {   
                $request = Request::requestHeaders( $clientBuffer );

            
                echo $request->header('Host') . $request->uri() . " \r\n";

                if(!is_null($request->header('Sec-Fetch-User')) || $request->header('Sec-Fetch-Mode') == 'cors')
                {

                    $response = $this->handle($request);

                    $response = call_user_func( $callback,  $request, new OutgoingResponse($response));
                    
                
                    if ( !$response || !$response instanceof OutgoingResponse )
                    {
                        $response = OutgoingResponse::error( 404 );
                    }
        
                }
            }
          
        

            

           
            $response = (string) $response;

            
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







