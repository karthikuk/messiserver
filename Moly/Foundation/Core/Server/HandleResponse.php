<?php
namespace Moly\Server;

use Moly\Server\Contracts\HandleResponseContract;
use Moly\Server\Request\ServerRequest;
use Moly\Supports\Facades\Request;
use Moly\Supports\Facades\Response;

class HandleResponse implements HandleResponseContract
{

    protected $_socket;

    protected $_serverRequest = null;

    protected $_serverResponse = null;

    protected $_callback = null;
 

    public function __construct($socket = null)
    {
        $this->_socket = $this->_socket ?? $socket;
    }


    public function handle(Callable $requestAbstract, $callback) : self
    {       
        $this->_serverRequest = $requestAbstract();

        $this->_callback = $callback;

        $this->makeResponse();

        return $this;
    }
    

    protected function makeResponse() 
    {

        
        if(!is_null($this->_serverRequest->header('Sec-Fetch-User')) 
                || $this->_serverRequest->header('Sec-Fetch-Mode') == 'cors' 
                || $this->_serverRequest->header('Upgrade-Insecure-Requests'))
        {
  
            $this->_serverResponse = MessiRouter::instance()
                                                ->router()
                                                ->next($this->_serverRequest);

            
                                 
            $this->_serverResponse = call_user_func( $this->_callback ,  $this->serverRequest(),  $this->_serverResponse);
        }  
        else
        {

            $this->_serverResponse = $this->multipleResources($this->_serverRequest);

        }  
      
     
        return $this;
    }

    public function serverRequest()
    {
        return $this->_serverRequest;
    }


    public function serverResponse()
    {
        return $this->_serverResponse;
    }

    protected function multipleResources(?ServerRequest $request)
    {
        $serverPath = "C:\\xampp\\htdocs\\Php\\1-b\\";

        $resource =  explode("/", $request->uri());

        $resource =  array_pop($resource);
      
        return Response::resources($serverPath.$resource);

    }
   
    
    public function next() : string
    {
        return $this->serverResponse()->send();
    }
   
}







