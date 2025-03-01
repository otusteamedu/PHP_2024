<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
require __DIR__ . '/../vendor/autoload.php';

use App\Application\Services\QueueService;
use App\Infrastructure\Api\V1\Controllers\QueueController;
use Predis\Client as RedisClient;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$app = AppFactory::create();

$config = require __DIR__ . '/../app/config/config.php';
$redis = new RedisClient($config['redis']);
$queueService = new QueueService($redis);

// Настройка Twig
$twig = Twig::create(__DIR__ . '/../app/templates', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));


// Маршрут для отображения формы
$app->get('/', function ($request, $response) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'form.html.twig');
});

// Маршруты для запросов
$app->post('/api/v1/request', [new QueueController($queueService), 'addRequest']);
$app->get('/api/v1/request/{id}', [new QueueController($queueService), 'getStatus']);

// Маршруты для Swagger
$app->get('/openapi.json', function ($request, $response) {
    $openapiJson = file_get_contents(__DIR__ . '/../openapi.json');
    $response->getBody()->write($openapiJson);
    return $response->withHeader('Content-Type', 'application/json');
});
$app->get('/swagger', function ($request, $response) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'swagger.html.twig');
});

$app->run();
