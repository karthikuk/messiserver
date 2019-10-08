<?php
namespace Moly\Contracts;

use Moly\Server\Request\ServerRequest;

interface ServerRequestInterface{

    public function mergeInputRequests();

    public function input();
   
    public function isEmpty();
    
    public function method();  
    
    public function uri();
  
    public function setInstance(ServerRequest $instance);
    
    public function getInstance();
    
    public function header( $key, $default = null );
    
    public function requestHeaders($header);

    public function requestHeadersWithOutServe();

    public function isRunningOnInbuiltServer();
}