<?php
namespace App\Factory\Pizza;

use App\Controllers\Pizza\PizzaCollections;
use App\Controllers\Pizza\PizzaProcess;
use Moly\Supports\Facades\Request;

class PizzaFactory implements PizzaFactoryInterface{

    public $pizzaCollections;

    public function __construct(Request $request, PizzaCollections $pizzas)
    {
        $this->pizzaCollections = $pizzas;
    }

    public function pizza($pizza)
    {
        return $this->pizzaCollections->resolve($pizza);
    }

    public function order($pizza) 
    {
        $orderedPizza = $this->pizzaCollections->resolve($pizza);   

        $this->start( $orderedPizza);
    }


    public function start(PizzaProcess $pizza)
    {
        $pizza->make();
    }
    
}
