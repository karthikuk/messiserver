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
        
    
        if($this->_serverRequest->isRoute())
        {
            $this->_serverResponse =  MServer::router()->next($this->_serverRequest);
               
            $this->_serverResponse = call_user_func( $this->_callback ,  $this->serverRequest(),  $this->_serverResponse);
        }
        else
        {
            $this->_serverResponse = $this->resolveAssets($this->_serverRequest);
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

    protected function resolveAssets(?ServerRequest $request)
    {
        

        $resource =  $request->uri();

      
        return Response::resources($resource);
    }
   
    
    public function next() : string
    {
        return $this->serverResponse()->send();
    }
   
}







