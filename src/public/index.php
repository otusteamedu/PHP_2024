<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
require __DIR__ . '/../vendor/autoload.php';

use App\Application\Services\QueueService;
use App\Infrastructure\Controllers\Api\V1\QueueController;
use App\Infrastructure\Controllers\Web\HomeController;
use App\Infrastructure\Controllers\Web\SwaggerController;
use Predis\Client as RedisClient;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

const ROOT_PATH = __DIR__ . '/../';

$app = AppFactory::create();

$config = require ROOT_PATH . 'app/Infrastructure/config/config.php';

// Настройка Twig
$twig = Twig::create(ROOT_PATH . 'app/Infrastructure/templates', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

// Сервис очередей
$redis = new RedisClient($config['redis']);
$queueService = new QueueService($redis);


// Маршрут для отображения формы
$app->get('/', [new HomeController($twig), 'home']);

// Маршруты для Swagger
$app->get('/swagger', [new SwaggerController($twig), 'getSwaggerUi']);
$app->get('/openapi.json', [new SwaggerController($twig), 'getOpenApiJson']);

// Маршруты для запросов
$app->post('/api/v1/request', [new QueueController($queueService), 'addRequest']);
$app->get('/api/v1/request/{id}', [new QueueController($queueService), 'getStatus']);

$app->run();
