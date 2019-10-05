<?php


use Moly\Supports\Facades\Request;
use Moly\Supports\Facades\Response;
use Moly\Supports\Facades\Route;



Route::get('/', function () {

    $data = array(
        "body" => 'dashboard',
        'name' => "karthi",
        'age' => "18",
    );


  
    //exit;
    
    return view('layouts.layout', $data);
});



Route::get('/products', function () {

    return view('layouts.layout', ['body' => 'products']);

});



Route::get("/pizza/{choice}", "App\Controllers\Pizza\PizzaController::show");

Route::get("/hello/{choice}", "App\Controllers\Pizza\PizzaController::hello");

Route::get('/productEdit/{product}', function () {
    return view('layouts.layout', ['body' => 'pizzaedit']);
});

Route::put('/putPizza/{id}',"App\Controllers\Pizza\PizzaController::putPizza");

Route::patch('/patchPizza',"App\Controllers\Pizza\PizzaController::patchPizza");




Route::post('/postPizza', function () {

 
    $input = Request::input();

   
    return Response::redirect('/products');
    
    // ob_flush();
    // flush();

    //return view('layouts.layout', ['body' => 'products']);
    //echo "<h1> Welcome </h1>";



    // return json_encode($input);
    
    // /
    //echo 'redirect::>/products';   
});







?>