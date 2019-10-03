<?php
namespace App\Controllers\Pizza;

class BeefPizza extends PizzaProcess {

    
    
    public function isAvailable() : bool
    {
        return false;
    }

    public function toppings()
    {
        var_dump('Beef Toppings');
        
        return $this;
    }

  

}