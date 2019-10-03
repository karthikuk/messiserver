<?php
namespace App\Controllers\Pizza;

class ChickPizza extends PizzaProcess {

  
    public function isAvailable() : bool
    {
        return true;
    }

    
    public function toppings()
    {

        var_dump('Chicken Toppings');

        return $this;
    }

  

}