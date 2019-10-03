<?php
namespace App\Factory\Pizza;

use App\Controllers\Pizza\PizzaProcess;

interface PizzaFactoryInterface {

    public function pizza($pizza);
    public function order($pizza);
    public function start(PizzaProcess $pizzaprocess);
}