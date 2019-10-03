<?php 
namespace Moly\Foundation\Providers;


use Moly\Core\Route\Router;
use Moly\Core\View\View;
use Moly\Providers\ServiceProvider;
use Moly\Server\Request\Game;
use Moly\Server\Request\IncomingRequest;

class FoundationProvider extends ServiceProvider {

    public function register(){
       
        $this->app->make(Router::class, function() {
            return new Router;
        }, true);

        $this->app->make(Game::class, function() {
            return new Game;
        }, true);


        $this->app->singleton('view', function () {
            return new View();
        });

        $this->app->singleton('request', function () {
            return new IncomingRequest;
        });

        
      
    }
}