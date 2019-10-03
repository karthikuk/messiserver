<?php 
namespace Moly\Core\Route;


use Moly\Core\View\View;
use Moly\Middleware\VerifyCsrfToken;
use Moly\Supports\Facades\Request;

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

      
       
        

        // exit;

        //     $headers = apache_response_headers();
        // var_dump($headers);
       // dd($GLOBALS);
        // $csrf = new VerifyCsrfToken;

  
        // $csrf->handle(Request::input(), function ($request) {
        //    dd($request);
        // });
        
        
        // $uri =  $_SERVER["PATH_INFO"] ?? $_SERVER["REQUEST_URI"];
        
        
        //$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $uri = $request->uri();


        $request = (new RouteObject($uri));
    
       
    
        
        $segment = $request->isRootSlug() ? $request->uriString() : "/{$request->segment(0)}";

        
    
        
        

        if(!isset($this->routes[$segment]))
        {
            throw new \Moly\Exceptions\RouteNotFoundException;

            return true;
        }


        $matchedRoute = $this->routes[$segment];
       

        $matchedRoute->methodsAuthorized();

        
        if($matchedRoute->checkActionIsCallable())
        {
         
       
            //return function () use ($matchedRoute) {
                return $matchedRoute->action();
           // };
            
        }

        


        $reflections = new \Moly\Supports\Reflections(
                                $matchedRoute->accessorClass(), 
                                $matchedRoute->accessorMethod(), 
                                array_values($matchedRoute->bindRouteParams($request))
                        );
        

       // return function () use ($reflections) {
            return $reflections->instance();

       // };
            
                    
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

