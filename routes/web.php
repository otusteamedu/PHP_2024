<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'api/v1'
], function () use ($router) {
    $router->post('/tasks', 'TaskController@create');
    $router->get('/tasks/{taskId}', 'TaskController@getTask');
});
