<?php


use Moly\Supports\Facades\Request;
use Moly\Supports\Facades\Response;
use Moly\Supports\Facades\Route;



Route::get('/', function () {

    $data = array(
        "body" => 'pages/dashboard',
        'name' => "karthi",
        'age' => "18",
    );


    return view('layouts.index', $data);
});


Route::get('/login', function () {
    return view('layouts.index', ['body' => 'pages/login']);
});

Route::get('/register', function () {
    return view('layouts.index', ['body' => 'pages/register']);
});

Route::get('/forget-password', function () {
    return view('layouts.index', ['body' => 'pages/forgot-password']);
});

Route::get('/404', function () {
    return view('layouts.index', ['body' => 'pages/404']);
});

Route::get('/tables', function () {
    return view('layouts.index', ['body' => 'pages/404']);
});


Route::get('/products', function () {
    return view('layouts.index', ['body' => 'pages/products']);
});

Route::get('/productEdit/{product}', function () {
    return view('layouts.index', ['body' => 'pizzaedit']);
});




Route::get("/pizza/{choice}", "App\Controllers\Pizza\PizzaController::show");

Route::get("/hello/{choice}", "App\Controllers\Pizza\PizzaController::hello");



Route::put('/putPizza/{id}',"App\Controllers\Pizza\PizzaController::putPizza");

Route::patch('/patchPizza',"App\Controllers\Pizza\PizzaController::patchPizza");




Route::post('/postPizza', function () {

    $input = Request::input();

    return Response::redirect('/products');     

});


Route::get('/getFile', function () {
    return Response::stream("C:\\xampp\\htdocs\\Php\\1-b\\1.csv");
});








?>