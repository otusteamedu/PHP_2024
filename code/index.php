<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Viking311\Api\Infrastructure\Factory\Command\AddEventCommandFactory;
use Viking311\Api\Infrastructure\Factory\Command\GetStatusCommandFactory;

require __DIR__ . "/vendor/autoload.php";

$app = AppFactory::create();

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->post('/api/v1/events', function (Request $request, Response $response){
    $cmd = AddEventCommandFactory::createInstance();
    return $cmd->execute($request, $response);
});


$app->get('/api/v1/events/{eventId}', function (Request $request, Response $response, array $args){
    $cmd = GetStatusCommandFactory::createInstance();
    return $cmd->execute($request, $response, $args['eventId']);
});

$app->run();