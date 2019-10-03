<?php 
namespace App\Providers;

use Moly\Core\Request\RequestCatch;
use Moly\Core\Route\Router;
use Moly\Core\View\Views;
use Moly\Providers\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    public function register(){
       
        // $this->app->make(Router::class, function() {
        //     return new Router;
        // }, true);


        // $this->app->singleton('view', function () {
        //     return new Views;
        // });

        // $this->app->singleton('request', function () {
        //     return new RequestCatch;
        // });
    }
}