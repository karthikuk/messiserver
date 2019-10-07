<?php
namespace Moly\Server\Request;



abstract class ServerRequest  {

    protected $inbuildServer = false;

    protected $rawHeaders = null;

    protected static $instance = null;

    public function requestHeaders( $header )  
    {

        parse_str(file_get_contents("php://input"),$requests);

        $this->inbuildServer = true;

        $this->rawHeaders = $header;

        $this->headerWithLines();

        $this->resolveUriAndMethod();

        $this->headersWithKey();

        return $this->setInstance($this);
       
    }

    protected function headerWithLines()
    {
        $this->rawHeaders = explode( "\n", $this->rawHeaders );

        return $this;
    }

    
    protected function resolveUriAndMethod()
    {
        list( $this->method, $this->uri ) = explode( ' ', array_shift( $this->rawHeaders ) );

        $this->method = strtoupper( $this->method );

        $this->resolveParams();

        return $this;
    }

    protected function resolveParams()
    {

        @list( $this->uri, $params ) = explode( '?', $this->uri );

        $this->parseParameters($params);

        return $this;
    }

    protected function parseParameters($params)
    {
        parse_str( $params, $this->parameters );

        $this->request = array_merge($this->request, $this->parameters);

        return $this;
    }



    protected function headersWithKey()
    {
        $this->headers = [];


        foreach( $this->rawHeaders as $line )
        {
          
            $line = trim( $line );
            
            if ( strpos( $line, ': ' ) !== false )
            {
                list( $key, $value ) = explode( ': ', $line );

                $this->headers[$key] = $value;
            }
            else
            {
                if($line) $this->parseParameters($line);
            }

           // echo $line ." \r \n";
        }   

        return $this;
    }


    public function requestHeadersWithOutServe()
    {
      
        if(!isset($_SERVER['REQUEST_URI']))
        {
            return true;
        }
        $this->inbuildServer = false;

        $uri = $_SERVER['REQUEST_URI'];

        $this->uri = parse_url($uri, PHP_URL_PATH);

        $this->parseParameters(parse_url($uri , PHP_URL_QUERY));

        $this->method = $_SERVER['REQUEST_METHOD'];

        
        foreach ($_SERVER as $key => $value) 
        {
            if (strpos($key, 'HTTP_') === 0) 
            {
                $this->headers[str_replace('_','-',str_replace('HTTP_','',$key))] = $value;
            }
        }
    }

    public function isRunningOnInbuiltServer()
    {
        return $this->inbuildServer;
    }

    
    abstract public function setInstance(ServerRequest $request);

    abstract public function getInstance();

    abstract public function input();

    abstract public function mergeInputRequests();

    abstract public function isEmpty();

    abstract public function uri();

    abstract public function header($key, $default = null);

}