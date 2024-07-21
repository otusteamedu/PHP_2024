<?php

declare(strict_types=1);

use App\Application\RequestDTO\FindEventRequest;
use App\Application\UseCase\AddEvent;
use App\Application\UseCase\ClearAll;
use App\Application\UseCase\FindEvent;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\RequestDTO\AddEventRequest;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../dependencies.php';

$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);


$app->post('/add-event', function (Request $request, Response $response) use ($app) {
    $requestBody = $request->getParsedBody();
    $useCase = new AddEvent($app->getContainer()->get('redisRepository'));
    $addEventRequest = new AddEventRequest($requestBody['priority'], $requestBody['conditions']);
    $addEventResponse = ($useCase)($addEventRequest);
    $response->getBody()->write(json_encode($addEventResponse));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/clear-all', function (Request $request, Response $response) use ($app) {
    $useCase = new ClearAll($app->getContainer()->get('redisRepository'));
    $learAllRespose = ($useCase)();
    $response->getBody()->write(json_encode($learAllRespose));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/find-event', function (Request $request, Response $response) use ($app) {
    $requestBody = $request->getParsedBody();
    $useCase = new FindEvent($app->getContainer()->get('redisRepository'));
    $findEventRequest = new FindEventRequest($requestBody['conditions']);
    $findEventRequest = ($useCase)($findEventRequest);
    $response->getBody()->write(json_encode($findEventRequest));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
