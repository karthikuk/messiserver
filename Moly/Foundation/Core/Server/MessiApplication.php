<?php
namespace Moly\Server;



class MessiApplication
{

    protected $_app = null;

    protected static $_instance = null;
   
    public function __construct($app = null)
    {
        $this->_app = $app;
    }   


    public static function instance($app =  null)
    {
        if(!self::$_instance)
        {
            self::$_instance = (new static($app));
        }

        return self::$_instance;
    }

    public function getInstance() : ?self
    {
        return $this->_instance;
    }  
    
    public function app()
    {
        return $this->_app;
    }

    
}








