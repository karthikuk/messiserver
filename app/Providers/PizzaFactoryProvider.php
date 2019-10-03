<?php 
namespace App\Providers;

use App\Factory\Pizza\PizzaFactory;
use Moly\Providers\ServiceProvider;

class PizzaFactoryProvider extends ServiceProvider {

    public function register(){
       
        $this->app->make(PizzaFactory::class, null, true);
    }
}