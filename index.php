<?php

use Moly\Server\Request\IncomingRequest;
use Moly\Supports\Facades\App;

require 'vendor/autoload.php';




  
  


$app = require 'bootstrap/bootstrap.php';


$s = serialize($app);
file_put_contents('store', $s);


$s = file_get_contents('store');
$a = unserialize($s);



























$router = $app->resolve("Moly\Core\Route\Router", true);



$router->next(new IncomingRequest);







