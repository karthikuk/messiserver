<?php

use Moly\Supports\Facades\App;


$_SESSION['_token'] = '';

if(!function_exists('view'))
{
    function view($view, $data = array())
    {
        return App::resolve('view', true)->make($view, $data);
    }
}

if(!function_exists('view_contents'))
{
    function view_contents($view, $data = array())
    {
        return App::resolve('view', true)->make($view, $data);
    }
}

if(!function_exists('csrf_token'))
{
    function csrf_token()
    {
        //session_start();
        
        $token = md5(uniqid(rand(), TRUE));
 
        $_SESSION['_token'] = $token;
    
        //$_SESSION['secret_data'] = "Top secret data";

        return $token;
    }
}