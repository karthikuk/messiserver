<?php
namespace Moly\Foundation;

use Moly\Supports\Reflections;

class Container {

    protected  $bindings = [];

    protected  $instances = [];

    protected  $resolved = [];

    protected static $instance = null;


    public static function getInstance()
    {
        if (is_null(static::$instance)) 
        {
            static::$instance = (new static);
        }

        return static::$instance;
    }

 
    public function bind($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function bindContainer()
    {
        return $this->bindings;
    }

    public function make($abstract, $concrete =  null, $shared = false )
    { 


        


        if(is_null($concrete))
        {
            $this->resolved[$abstract] = $abstract;

           
            return;
        }


       
        if((new \ReflectionFunction($concrete))->isClosure())
        {
            
            $this->bindings[$abstract] = $concrete;

            if($shared)
            {
                $this->instance($abstract, $concrete());
            }

          
    
            return $this->resolve($abstract, $shared);

        }
        

       
       
    
    }



    public function singleton($abstract, $concrete, $shred = false)
    {
        $this->bindings[$abstract] = $concrete;

        $this->instance($abstract, $concrete());
    }

    public static function setInstance(Application $instance)
    {
        return static::$instance = $instance;
    }

    public function resolve($abstract, $shared = false)
    {
        
       
        if(array_key_exists($abstract,$this->resolved))
        {
            return (new Reflections($abstract))->instance();  
        }

        if($shared)
        {
            return $this->instances[$abstract];
        }

        return $this->bindings[$abstract]();
    }
    

   

}