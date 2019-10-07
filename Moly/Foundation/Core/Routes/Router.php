<?php 
namespace Moly\Core\Route;


use Moly\Core\View\View;
use Moly\Middleware\VerifyCsrfToken;
use Moly\Supports\Facades\Request;
use Moly\Supports\Facades\Response;
use Moly\Server\Response\OutgoingResponse;


interface RouterInterface 
{

    public function get(string $uri, $closure);

    public function post(string $uri, $closure);

    public function put(string $uri, $closure);

    public function patch(string $uri, $closure);

    public function delete(string $uri, $closure);

    public function go(string $uri);

    public function of(string $uri,array $arguments);

    public function next();

    public function getRoutes();
}


class Router implements RouterInterface
{
    

    protected $routeObject;
    
    protected static $instance = null;

    public function __construct()
    {  
        $this->routeObject = clone new RouteObject();
    }

    protected $requests = [];

    protected $routes = [];

    public static function getInstance()
    {        
        if (!isset(static::$instance))
        {
            static::$instance = new static;
        }

        return static::$instance;
    }
    
   

    public function get($uri, $closure) 
    {   

        
        $methods = ['GET', 'HEAD'];

        $routeObj =  (new RouteObject($uri))->setMethods($methods)->setClosure($closure);

        $this->pushRoutes($routeObj); 
                
    }

    public function post($uri, $closure) 
    {   

        $thisInstance = self::getInstance();
      
        $methods = ['POST'];
     
        $routeObj =  (new RouteObject($uri))->setMethods($methods)->setClosure($closure);

        $this->pushRoutes($routeObj);       
    }

    public function put($uri, $closure) 
    {   
        $methods = ['PUT'];

        $routeObj = (new RouteObject($uri))->setMethods($methods)->setClosure($closure);

        $this->pushRoutes($routeObj);      
    }

    public function patch($uri, $closure) 
    {   
        $methods = ['PATCH'];

        $routeObj = (new RouteObject($uri))->setMethods($methods)->setClosure($closure);

        $this->pushRoutes($routeObj);       
    }

    public function delete($uri, $closure) 
    {   
        $methods = ["DELETE"];

        $routeObj = (new RouteObject($uri))->setMethods($methods)->setClosure($closure);

        $this->pushRoutes($routeObj);
        
    }

    public function pushRoutes(RouteObjectInterface $routeObj)
    {

        $thisInstance = self::getInstance();

        $this->routes[$routeObj->uriString()] = $routeObj;    

      
        //$thisInstance->routes[$routeObj->uriString()] = $routeObj;    
        
    }

    public function go($uri)
    {
        return redirect($uri);
    }

    public function of($uri, $arguments = [])
    {
       

        if(!empty($arguments))
        {
            $argv =  implode("/", $arguments);
            
            return "/{$uri}/{$argv}";

        }

        return "/{$uri}";
      
    }


    public function next($request = null)
    {

    
        $uri = $request->uri();

        

        $request = $this->givenUriRequest($uri);
    
        
        $segment = $this->resolveSegment($request);

     
        if(!isset($this->routes[$segment]))
        {
            throw new \Moly\Exceptions\RouteNotFoundException;

            return true;
        }


        $matchedRoute = $this->matchedRoute($segment);
       

        $matchedRoute->methodsAuthorized();

        
        if($matchedRoute->checkActionIsCallable())
        {
         
                return $this->routeResponse($matchedRoute->action());  
        }
        else
        {   
            $reflections = new \Moly\Supports\Reflections(
                                    $matchedRoute->accessorClass(), 
                                    $matchedRoute->accessorMethod(), 
                                    array_values($matchedRoute->bindRouteParams($request))
                            );

            return $this->routeResponse($reflections->instance());  
             
        }
         
    }

    protected function givenUriRequest(string $uri) : RouteObject
    {
        return new RouteObject($uri);
    }

    protected function resolveSegment(RouteObject $request) : string
    {
        return $request->isRootSlug() ? $request->uriString() : "/{$request->segment(0)}";
    }

    protected function matchedRoute($segment) : RouteObject
    {
        return $this->routes[$segment];
    }

    protected function routeResponse($response): OutgoingResponse
    {

       
        if (!$response || !$response instanceof OutgoingResponse)
        {

            return Response::make(200, $response);
        }

        
        

        return $response;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
    
    public function initiate()
    {
        require __DIR__.'/../routes/routes.php';
    }
}

