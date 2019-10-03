<?php
namespace Moly\Core\View;

use Moly\Server\Response\OutgoingResponse;
use Moly\Supports\Facades\Request;

class View {

    const VIEW_PATH = __DIR__.'/../../../../templates/';


    public function make(string $view, $data = array())
    {
      

        $contents = $this->resolveContents($data);

        if($contents)
        {
            $data['body'] = $contents;
        }

      

        $view  = $this->viewRelativeName($view);

        if(!file_exists($view))
        {
            throw new \Exception("View [$view] Not Found");

            return true;
        }
        

        ob_start();
       
        return $this->viewWithResponse($view, $data);
      
    }

 

    protected function viewWithResponse($view, $data)
    {
        extract($data);
        
        if(Request::isRunningOnInbuiltServer())
        {
            include $view;

            return ob_get_clean();
        }
        else
        {
            return include $view;

            ob_get_clean();
        }
       
    }

    protected function viewRelativeName($view)
    {
       
        $view = str_replace(".", "/", $view);

        $view = self::VIEW_PATH.$view;

        return $view =  "$view.tpl.php";

    }

    protected function resolveContents($data = [])
    {
        if(empty($data))
        {
            return;
        }


        if(!isset($data['body']))
        {

            return;
        }

        $view = $this->viewRelativeName($data['body'], $data);
        ob_start();
            extract($data);
            include $view ;
        return ob_get_clean();
    }
}

class ViewEngine 
{

    protected $view;

    public function __construct($view)
    {
        $this->view = $view;    

        $this->viewRendering();
    }

    protected function viewRendering()
    {
        $contents = file_get_contents($this->view);

        // $contents = '<ul class="nav nav-pills nav-stacked"><li class="active"><a href="#section1">Dashboard</a></li><li><a href="{{ Route::make() }}">Age</a></li><li><a href="#section3">Gender</a></li><li><a href="#section3">Geo</a></li></ul><br>';
    
        // preg_match_all('/({{)( [a-zA-Z0-9_]* )(}})/',$contents, $matches);

        // //$findInterpolation =  $contents
        // dd($matches);
        // dd($contents);
    }
}