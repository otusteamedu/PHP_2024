<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\UsersControllers;

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

/*
$router->get('/', function () use ($router) {
    //return $router->app->version();
    return view('interface');
});
*/
$router->get('/', 'ViewController@users');
$router->get('/create', 'ViewController@create');
$router->post('/create', 'ViewController@upload');
$router->get('/u/{id}', "ViewController@user");

$router->post('departments', 'DepartmentsController@dump');
$router->get('departments', 'DepartmentsController@index');
$router->get('department/{id}', 'DepartmentsController@search');
$router->put('departament/{id}', 'DepartmentsController@update');
$router->delete('departamen/{id}', 'DepartmentsController@delete');

$router->post('users', 'UsersController@dump');
$router->get('users', 'UsersController@index');
$router->get('user/{id}', 'UsersController@search');
$router->put('user/{id}', 'UsersController@update');
$router->delete('user/{id}', 'UsersController@delete');
