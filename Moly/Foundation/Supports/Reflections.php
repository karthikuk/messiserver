<?php
namespace Moly\Supports;

class Reflections {
    
    public $class = null;
    public $method = null;
    public $resolvedParams = array();
    public  $reflector;
    public  $rIndex = 0;

    public function __construct($class, $method = null,  $resolvedParams = null)
    {
        $this->class = $class;
        $this->method = $method;
        $this->resolvedParams = $resolvedParams;
    }

    public function instance()
    {
        return $this->resolve($this->class, $this->method, $this->resolvedParams);
    }

    public function resolve($class, $method = null, $resolvedParams = null)
	{
       

        $reflector = new \ReflectionClass($class);
       
      
		if( ! $reflector->isInstantiable())
 		{
 			throw new \Exception("[$class] is not instantiable");
 		}
		
 		$constructor = $reflector->getConstructor();
 		
		
 		if(is_null($constructor))
 		{
          
 			return new $class;
 		}
        
       
       
        $parameters = $constructor->getParameters();

        $dependencies = $this->dependencies($parameters);
         
         
        if($method)
        {
           
            $newReflector = $reflector->newInstanceArgs($dependencies);
            return call_user_func_array(array($newReflector, $method), $this->methodReflections($reflector, $method));
        }

       

        return $reflector->newInstanceArgs($dependencies);
        
    }

    public function methodReflections($reflector, $method)
    {
        $methods = $reflector->getMethod($method); 

        $parameters =  $methods->getParameters();

        $dependencies = $this->dependencies($parameters);

      
        if(count($this->resolvedParams) !== $this->rIndex)
        {
            throw new \Exception("Argumets Missing");
        }
    
        return $dependencies;
    }

    

    public function dependencies($parameters)
	{
		$dependencies = array();
        
        

		foreach($parameters as $key => $parameter)
		{
			$dependency = $parameter->getClass();
			
			if(is_null($dependency))
			{
            
                if($parameter->isDefaultValueAvailable())
                {
                    $dependencies[] = $parameter->getDefaultValue();
                }
                else
                {
                    $dependencies[] = $this->resolvedParams[$this->rIndex];

                }

                $this->rIndex++;
                
			}
			else
			{
				$dependencies[] = $this->resolve($dependency->name);
			}
        }
		
		return $dependencies;
    }


    
	public function resolveNonClass(ReflectionParameter $parameter)
	{
       
		if($parameter->isDefaultValueAvailable())
		{
			return $parameter->getDefaultValue();
		}
		
		throw new Exception("Erm.. Cannot resolve the unkown!?");
    }
    
}