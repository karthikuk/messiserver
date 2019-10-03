<?php
namespace Moly\Server;

use Moly\Server\Request\ServerRequest;
use Moly\Server\Response\OutgoingResponse;
use Moly\Supports\Facades\Request;

class OriginalServer {

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

        $this->createSocket();

        $this->bindSocket();

       
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

    
    protected function createSocket()  
    {
        $this->socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
    }

    protected function bindSocket()  
    {
        if ( !socket_bind( $this->socket, $this->host, $this->port ) )
        {
            throw new Exception( 'Could not bind: '.$this->host.':'.$this->port.' - '.socket_strerror( socket_last_error() ) );
        }

        echo "$this->port Listening  \r\n";
    }

 

    public function listen($callback = null )  
    {
        
        
        

        if (!is_callable($callback))
        {
            throw new \Exception('The given argument should be callable.');
        }

       
        
        socket_listen( $this->socket,  5);

        

        while (true) 
        {
           
            

            if ( !$client = socket_accept( $this->socket ) ) 
            {
                var_dump('Close');

                socket_close( $client );continue;
            }

       


         


         

            $clientRequest = socket_read($client, 1024);
        
       
           
            $response = "";

            if($clientRequest)
            {   
                $request = Request::requestHeaders( $clientRequest );

                var_dump($request);

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

        
            socket_write( $client, $response, strlen( $response ) );


            


            socket_close( $client );
        }
    }


    public function handle(ServerRequest $request)
    {
        $router = $this->getRouter();

        return $router->next($request);
    }
}







