<?php
namespace App\Controllers\Pizza;

use App\Controllers\Controller;
use App\Controllers\Products\Products;
use App\Factory\Pizza\PizzaFactory;

use Moly\Supports\Facades\App;
use Moly\Supports\Facades\Request;

class PizzaController extends Controller{

    public $products;

    public $request;

    public $game;

    public function __construct(Request $request, Products $products) 
    {
        $this->products = $products;    

        
        $this->request = $request;  

       
    }

    public function show(string $pizza)
    {


       
        $yourPizza = [
            "body" => "pizza",
            "choosed" => $pizza,
            "order" => ""
         
        ];

        return view("layouts.layout", $yourPizza);
    }

  

    public function hello(string $text = null)
    {
        return view('hello', ['text' => $text]);
    }

    public function putpizza($id)
    {
        dd($id);
    }

    public function patchPizza(Request $request)
    {
        print_r($request->input('age'));
    }

    public function deletePizza($id)
    {
        dd($this->request);
    }
}