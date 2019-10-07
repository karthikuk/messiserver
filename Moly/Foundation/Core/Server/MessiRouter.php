<?php
namespace Moly\Server;



class MessiRouter
{

    protected $_router = null;

    protected static $_instance = null;
   
    public function __construct($router = null)
    {
        $this->_router = $router;
    }   


    public static function instance($router = null)
    {
        if(!self::$_instance)
        {
            self::$_instance = (new static($router));
        }

        return self::$_instance;
    }

    public static function getInstance()
    {
        return self::$_instance;
    }   

    public function router()
    {
        return $this->_router;
    }
}








