<?php 
namespace Moly\Server\Request;


class IncomingRequest extends ServerRequest    {


    protected $uri = null;  

    protected $method = null;  

    protected $parameters = [];  
    
    protected $headers = [];  

    protected static $instance = null;
    
    public $request = array();

    public function __construct()
    {
        $this->requestHeadersWithOutServe();

        $this->mergeInputRequests();
    }
    

    public function mergeInputRequests()
    {

        $this->getInputs();

        $this->postInputs();

        $this->otherInputs();

        $this->csrfTokenKey();

        return $this->request;
    }

    protected function getInputs()
    {
        $this->request = array_merge($this->request, $_GET);
        
        return $this;
    }

    protected function postInputs()
    {
        $this->request = array_merge($this->request, $_POST);
        
        return $this;
    }

    protected function otherInputs()
    {
        parse_str(file_get_contents("php://input"),$requests);

        $this->request = array_merge($this->request, $requests);

        return $this;
    }

    protected function csrfTokenKey()
    {

        if(!isset($this->request['_token']))
        {
            $this->request['_token'] = '';
        }
    }

    public function input(string $val =  null)
    {

        if($val) 
        {
            return $this->request[$val];
        }

        return $this->request;
    }

    public function isEmpty()
    {
        return empty($this->request);
    }

    public function method()  
    {
        return $this->method;
    }

    public function uri()  
    {
        return $this->uri;
    }

    public function setInstance(ServerRequest $instance)
    {
        return static::$instance = $instance;
    }


    public function getInstance()
    {
        if(!static::$instance)
        {
            static::$instance = new static;
        }

        return static::$instance;
    }


    public function header( $key, $default = null )  
    {
        if ( !isset( $this->headers[$key] ) )
        {
            return $default;
        }

        return $this->headers[$key];
    }
   
}