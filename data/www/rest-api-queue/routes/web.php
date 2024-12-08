<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->post('/tasks', 'TaskController@createTask');
$router->get('/tasks/{taskId}', 'TaskController@getTask');

$router->get('/swagger.json', function () {
    $openapi = \OpenApi\Generator::scan([env('CONTROLLER_PATH')]);
    return response()->json($openapi);
});
