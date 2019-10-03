<?php

use Moly\Server\Request\IncomingRequest;
use Moly\Supports\Facades\App;

require 'vendor/autoload.php';




  
  


$app = require 'bootstrap/bootstrap.php';





























$router = $app->resolve("Moly\Core\Route\Router", true);



$router->next(new IncomingRequest);







