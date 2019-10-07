<?php
namespace Moly\Server;



class MessiServerConfig
{

    protected $_config = []; 

    protected static $_instance = null;
   
    public function __construct(array $config = [])
    {
        $this->_config = $config;
    }   


    public static function instance(array $config = [])
    {
        if(!self::$_instance)
        {
            self::$_instance = (new static($config));
        }

        return self::$_instance;
    }

    public static function getInstance()
    {
        return self::$_instance;
    } 

    public function set($key,$value)
    {
        if(!isset($this->_config[$key]))
        {
            return $this->_config[$key] = $value;
        }

        return $this->get($key);
    }

    public function get($key)
    {
        return $this->_config[$key];
    }

    public function delete($key)
    {
        unset($this->_config[$key]);
    }

    public function config(array $config = [])
    {

        if(count($config))
        {
            return $this->_config = array_merge($this->_config, $config);
        }

        return $this->_config;
    }

    public function mergeItems(...$keys)
    {
        $value = "";

        foreach($keys as $key)
        {
            $value .= $this->get($key);
        }

        return $value;
    }

    public function hostwithport()
    {
        return $this->get('protocal')."://". $this->get('host') . ":" . $this->get('runningport');
    }

}







