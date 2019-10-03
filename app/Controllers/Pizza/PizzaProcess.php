<?php
namespace App\Controllers\Pizza;

abstract class PizzaProcess {

    public function make()
    {
        if(!$this->isAvailable()){

            $stocks =  (new PizzaCollections)->pizzaStock();
            var_dump('Sorry! Veggies is out of stock! Would you like to change another available stocks, it can listed bellow');
            var_dump( $stocks);
            return;
        }

        $this->breads()->minis()->tommatoChause()->toppings()->bake();
    }

    public function breads()
    {
        var_dump('Breadis are ready');

        return $this;
    }

    public function minis()
    {
        var_dump( 'Applying Minis');

        return $this;
    }

    public function tommatoChause()
    {
        var_dump('Applying Tommato Chause');

        return $this;
    }


    public function bake() 
    {
        var_dump("Baking in process pls be patience 10 mins, will be ready");

        return $this;
    }

    abstract public function isAvailable();

    abstract public function toppings();

}