<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Models\QueueWork;

$router->get('/', function () use ($router) {
    return (new \App\Http\Controllers\JobRunController())->run();
});


$router->post('/some_request/', function () use ($router) {
    return (new \App\Http\Controllers\ApiController())->someWork();
});

$router->get('/check_status/', function(){
    return (new \App\Http\Controllers\ApiController())->checkStatus();
});
