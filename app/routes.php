<?php

declare(strict_types=1);

use App\Application\Actions\CustomerTask\CreateCustomerTaskAction;
use App\Application\Actions\CustomerTask\ViewCustomerTaskStatusAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/customer-task', function (Group $group) {
//        $group->get('', CreateCustomerTaskAction::class);
        $group->post('', CreateCustomerTaskAction::class);
        $group->get('/{id}', ViewCustomerTaskStatusAction::class);
    });
};
