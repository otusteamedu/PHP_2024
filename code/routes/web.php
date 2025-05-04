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

$router->post('/api/request', 'RequestController@create');
$router->get('/api/status/{requestId}/', 'RequestController@status');
$router->put('/api/update/{id}/{status}', 'RequestController@update');

$router->get('/', function () use ($router) {
    return $router->app->version();
});
