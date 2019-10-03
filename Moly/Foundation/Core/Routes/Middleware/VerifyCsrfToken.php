<?php
namespace Moly\Middleware;

use Moly\Exceptions\CSRFTokenExpiresException;

class VerifyCsrfToken {


    public function handle($request, $next)
    {

        if(isset($_POST['submit']))
        {
           
            if($request['_token'] == "")
            {
                throw new CSRFTokenExpiresException;
            }

            if($request['_token'] === $_SESSION['_token'])
            {
                $next($request);
            }
    
            
        }
       
 
    }

    public function next()
    {
        return true;
    }
}