<?php
namespace Moly\Contracts;

interface ServerRequestInterface{

    public function mergeInputRequests();

    public function input(string $val =  null);
   
    public function isEmpty();
    
    public function method();  
    
    public function uri();
  
    public function setInstance(ServerRequestInterface $instance);
    
    public function getInstance();
    
    public function header( $key, $default = null );
    
    public function requestHeaders($header);

    public function requestHeadersWithOutServe();

    public function isRunningOnInbuiltServer();
}