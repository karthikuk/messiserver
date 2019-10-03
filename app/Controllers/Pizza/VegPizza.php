<?php
namespace App\Controllers\Pizza;

class VegPizza extends PizzaProcess{


    public function isAvailable() : bool
    {
        return true;
    }
    
    public function toppings()
    {
        var_dump('Mixed Vegies Toppings');

        return $this;
    }
    

}