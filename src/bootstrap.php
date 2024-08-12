<?php

use App\Controller\IndexController;
use App\Provider\DatabaseProviderInterface;
use App\Provider\PostgresProvider;
use App\Queue\Queue;
use App\Queue\QueueInterface;
use App\Repository\RequestProcessRepository;
use App\Repository\RequestProcessRepositoryInterface;

require_once __DIR__ . "/../vendor/autoload.php";

$app = new Silex\Application();
$app['debug'] = $_ENV['APP_ENV'] == 'dev';

$app[QueueInterface::class] = fn () => new Queue();
$app[DatabaseProviderInterface::class] = fn () => new PostgresProvider();

$app[RequestProcessRepositoryInterface::class] = fn () => new RequestProcessRepository(
    $app[DatabaseProviderInterface::class]
);
$app[IndexController::class] = fn () => new IndexController(
    $app[QueueInterface::class],
    $app[RequestProcessRepositoryInterface::class]
);

$app->get('/{id}', function (int $id = 0) use ($app) {
    return $app[IndexController::class]->index($id);
})->value('id', 0);

$app->run();
