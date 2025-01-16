<?php

declare(strict_types=1);

use App\Banking\Http\Controller\Api\Statements\GenerateStatementAsyncController;
use App\Banking\Http\Controller\Api\Statements\GenerateStatementController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add(
    'statements.generate',
    new Route(
        path: '/api/statements',
        defaults: ['_controller' => GenerateStatementController::class],
        methods: ['POST']
    )
);

$routes->add(
    'statements.generate.async',
    new Route(
        path: '/api/async/statements',
        defaults: ['_controller' => GenerateStatementAsyncController::class],
        methods: ['POST']
    )
);

return $routes;
