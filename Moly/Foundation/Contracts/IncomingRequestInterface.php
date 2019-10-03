<?
namespace Moly\Contracts;


interface IncomingRequestInterface extends ServerRequestInterface{

    public function mergeInputRequests();

    public function input(string $val =  null);
   
    public function isEmpty();
    
    public function method();  
    
    public function uri();
  
    public function setInstance(ServerRequestInterface $instance);
    
    public function getInstance();
    
    public function header( $key, $default = null );

}