<?php
namespace Moly\Core\Route;

use Moly\Supports\Facades\Request;

interface RouteObjectInterface 
{

    public function setUri(string $uri);

    public function setClosure(string &$closure);

    public function setMethods(array $methods);

    public function setInstance();

    public function getInstance();

    public function routeFilters();

    public function routeSegments();

    public function routeParams();

    public function segments();

    public function methodsAuthorized();

    public function isRootSlug();

    public function segment(int $index);

    public function uriString();

    public function checkActionIsCallable();

    public function actionObject();

    public function action();

    public function accessorClass();

    public function accessorMethod();

    public function closureActions();

    public function bindRouteParams(RouteObjectInterface $route);

    public function checkRouteValid(RouteObjectInterface $route);

}

class RouteObject implements RouteObjectInterface
{

    protected $_HTTP_METHODS = [];

    protected $_slugSegments;

    protected $_slugString;

    protected $_orignalRouteSegments;

    protected $_uri;

    protected $_mapedRoute;

    protected $_route;

    protected $_routeParams; 

    protected $callableClosurable; 

    protected $closurable; 

    protected static $instance;

    protected $_resolvedParams = array();

    public function __construct($route = null)
    {
        $this->setInstance();

        $this->_uri = $this->removeEndSlash($route);

        $this->routeFilters();

    }

    public function setClosure(&$closure)
    {
        $this->closurable = $closure;

        $this->closureActions();

        return $this;
    }

    public function setUri($route)
    {
        $this->_uri = $this->removeEndSlash($route);

        $this->routeFilters();

        return $this;
    }

    public function setMethods(array $methods)
    {
        $this->_HTTP_METHODS = $methods;
        
        return $this;
    }


    public function setInstance()
    {
        if(static::$instance){

            return static::$instance;
        }

        return static::$instance = $this;
    }

    public function getInstance()
    {
        return static::$instance;
    }

    public function routeFilters()
    {
        $this->_orignalRouteSegments = array_values(array_filter(explode( "/",$this->_uri)));

        //$this->_orignalRouteSegments = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
  
        $matches = array();

        preg_match_all("/({)([a-zA-Z0-9_]*)(})/",$this->_uri, $matches);

        $this->_slugSegments = array_diff($this->_orignalRouteSegments,$matches[0]);

        $this->_routeParams = array_intersect ($this->_orignalRouteSegments,$matches[0]);

        $this->_slugString =  "/".implode("/",$this->_slugSegments); 

        $this->_resolvedParams = $this->routeParams();

        return $this;
    }

    public function removeEndSlash($uri)
    {
        return $uri;
    }

    public function routeSegments()
    {
      
        return $this->_orignalRouteSegments;
    }

    public function routeParams()
    {
        return $this->_routeParams;
    }

    public function segments()
    {
        return $this->_slugSegments;
    }
    
    public function methodsAuthorized()
    {
        //$method = $_SERVER['REQUEST_METHOD'];

    
        $method = Request::getInstance()->method();

 
    
        
        if(!in_array($method,$this->_HTTP_METHODS))
        {
            throw new \Moly\Exceptions\NotAllowedMethodException("Method Not Allowed! Check You Route");
        }

     
        switch ($method) 
        {
            case 'GET':
                    //
                break;

            case 'POST':
               
                    //
                break;

            case 'PUT':
                    //
                break;

            case 'PATCH':

                if(Request::getInstance()->isEmpty())
                {
                    throw new \Moly\Exceptions\NotAllowedMethodException("Patch Method should have array of inputs");
                }

                break;

            case "DELETE":
                //
                
                break;
        }
    }

    public function isRootSlug()
    {
        return count($this->segments()) === 0 ? true :  false;
    }

    public function segment($index)
    {
        return $this->segments()[$index];
    }

    public function uriString()
    {
        return  $this->_slugString; 
    }

    public function checkActionIsCallable()
    {
        if(gettype($this->closurable) == 'object')

            return true;

        return false;
    }

    public function actionObject()
    {
        return $this->closurable;
    }

    public function action()
    {

        
     
        $callable = $this->callableClosurable;
       
        return $callable();
    }



    public function accessorClass()
    {
        $callable = $this->callableClosurable;

        return $callable()[0];
    }

    public function accessorMethod()
    {
        $callable = $this->callableClosurable;

        return $callable()[1];
    }

    public function closureActions()
    {
       
        if(is_null($this->closurable))
        {
            return true;
        }

        if( gettype($this->closurable) == 'object')
        {

            $this->callableClosurable = $this->closurable;
        }
        else
        {
            $classAndMethod = explode("::", $this->closurable);

   
            $this->callableClosurable = function() use ($classAndMethod) {
                return $classAndMethod;
            };
        }
    }


    public function bindRouteParams(RouteObjectInterface $request)
    {
        $segments = $request->segments();

   

        array_walk($this->_resolvedParams, function($val, $index) use ($request, $segments) {

          
            if(!isset($segments[$index]))
            {
                throw new \Moly\Exceptions\RouteNotFoundException;
            }

            $this->_resolvedParams[$index] = $segments[$index];
            
        });

        $request->_resolvedParams  =  $this->_resolvedParams;

        return $this->_resolvedParams; 
    }

    public function checkRouteValid(RouteObjectInterface $request)
    {
        $this->bindRouteParams($request);
    }


}