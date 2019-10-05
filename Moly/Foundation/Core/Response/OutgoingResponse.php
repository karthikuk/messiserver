<?php
namespace Moly\Server\Response;
use Moly\Supports\Facades\Request;


class OutgoingResponse
{
   

    protected $response;

    protected $headerLines = [];

    protected static $statusCodes = [  
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',
    
        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
    
        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found', // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        // 306 is deprecated but reserved
        307 => 'Temporary Redirect',
    
        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
    
        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded'
    ];

    protected $status = 200;  
    protected $body = null;  
    protected $headers = [];  

    public function __construct($status = null, $body = null)
    {
        if ( !is_null( $status ) )
        {
            $this->status = $status;
        }

        $this->body = $body;

        $this->headerLines = [];

        $this->headerLines[] = "HTTP/1.1 ".$this->status." ".static::$statusCodes[$this->status];

        $this->header( 'Content-Type', 'text/html; charset=utf-8');
        
        $this->header( 'Server', 'MessiServer/1.0.0-Beta');
    }

    public function header( $key, $value )  
    {
        $this->headers[ucfirst($key)] = $value;
    }

    public function body()
    {
        return $this->body;
    }

    public static function error($code)
    {
        return self::$statusCodes[$code];
    }

    protected function buildHeaderString()  
    {
   
        foreach( $this->headers as $key => $value )
        {
            $this->headerLines[] = $key.": ".$value;
        }

        return implode( " \r\n",  $this->headerLines )."\r\n\r\n";
    }

    public function redirect($uri = null, $code = 302)
    {
        $this->headerLines[0] = "HTTP/1.1 302 Found";
        $this->header("Accept", 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3');
        $this->header("Host", 'http://192.168.2.53:8000');
        $this->header("Location", "http://192.168.2.53:8000$uri");
        return $this;
    }



    public function make($status = 200,$contents = null)
    {
        if($status) $this->status = $status;

        if($contents) $this->body = $contents;

        
        $this->responseInstanceOf();

        return $this;
    }

    protected function responseInstanceOf()
    {
        if(gettype($this->body) == 'array')
        {  
            $this->toJson();
        }   
    }

    public function toJson()
    {
        $this->body = json_encode($this->body);
       // $this->header('Content-Length', strlen($this->body));
        $this->header('Content-Type', 'application/json; charset=utf-8');
        $this->header('Access-Control-Allow-Origin', '*');
    }

    public function images()
    {
    

        $file = 'C:\xampp\htdocs\Php\1-b/1.jpg';
       // $this->header("Accept", 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3');
        $this->header('Content-Type', 'image/jpeg');
        $this->header("Content-Length", filesize($file) );
        $this->header('Connection', 'close');
        $this->header('Host', 'http://192.168.2.53:8000');

        //$fp = @fopen('C:\xampp\htdocs\Php\1-b/1.jpg', 'rb');
        //$this->body = file_get_contents('C:\xampp\htdocs\Php\1-b/1.jpg');
        //readfile('C:\xampp\htdocs\Php\1-b/1.jpg');

        // $fp = fopen('C:\xampp\htdocs\Php\1-b/1.jpg', 'w');
        // fwrite($fp, '1');
        // fwrite($fp, '23');
        // fclose($fp);

       
       
       // $this->body = file_get_contents($file);
       

        return $this;
    }

   

    public function send()
    {
        return $this->toString();
    }

    protected function toString()  
    {
        return $this->buildHeaderString().$this->body;
    }



}