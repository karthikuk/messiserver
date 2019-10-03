<?php
namespace App\Controllers\Pizza;

class PizzaCollections {

    private $pizzas = [];

    const AVAILABLE_TEXT = 'Pizza is Available';
    
    const NOT_AVAILABLE_TEXT = 'Not Available';


    public function pizzaCollection()
    {
        return $this->pizzas = [
            'veg' => VegPizza::class,
            'chick' => ChickPizza::class,
            'beef' => BeefPizza::class
        ];
        
    }

    public function resolve(string $pizza)
    {
        $collection =  $this->pizzaCollection();
        return (new $collection[$pizza]);
    }

    public function pizzaStock()
    {
        $stocks = [];

        $this->stocks = [
            'veg' => (new VegPizza)->isAvailable() ? self::AVAILABLE_TEXT : self::NOT_AVAILABLE_TEXT,
            'chick' => (new ChickPizza)->isAvailable() ? self::AVAILABLE_TEXT : self::NOT_AVAILABLE_TEXT,
            'beef' =>(new BeefPizza)->isAvailable() ? self::AVAILABLE_TEXT : self::NOT_AVAILABLE_TEXT
        ];

        return $this->stocks;
        
    }
    
}