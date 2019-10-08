<?php
namespace Moly\Server;

use Moly\Server\Contracts\ClientContract;
use Moly\Server\Facades\Client;
use Moly\Server\Facades\HandleRequest;
use Moly\Server\Facades\MRouter;
use Moly\Server\Facades\MConfig;
use Moly\Server\Handler\ServerHandler;

class MServer 
{

    protected static $app;

    protected static $router;

    protected $_client = null;

    protected $_incomingRequest = null;

    protected $_outgoingResponse = null;

    protected $_writeStream = null;
    
    protected $_handler = null;

    public function __construct(){}


    protected function makeConfig()
    {
        MessiServerConfig::instance([
            'host' => $this->host,
            'runningport' => $this->port,
        ]);
    }

    public function config(array $config = [])
    {

        MConfig::config($config);
       
        return $this;
    }


    protected function messiApplication($app)
    {
        return static::$app = MessiApplication::instance($app)->app();
    }

    public function application()
    {
       return static::$app;
    }
    
    public function messiRouter($abstract) : self
    {
        if($abstract instanceof Closure)
        {
            $abstract = $abstract();
        }
        
        static::$router = $abstract;

        MessiRouter::instance(static::$router)->router();
        
        return $this;
    }

    public function router()
    {
        return static::$router;
    }


    protected function requestHandlers($callback = null)
    {
        
       
        $this->_handler = (new ServerHandler($this->socket))->handle(function() {
            return null;
        }, $callback);
       
    
        $this->writeStream($this->_handler->client()->resource(), (string) $this->_handler->response()->send());

    }

    protected function writeStream($socket, $buffer)
    {
        $this->_writeStream = new WriteStream($socket, $buffer);

        return $this->_writeStream->doWrite();
    }

    public static function __callStatic($name, $arguments)
    {
        return $this->$name(...$arguments);
    }

}







