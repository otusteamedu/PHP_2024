<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Consumer\RequestConsumer;
use App\Controller\CreateRequestController;
use App\Controller\RequestStatusController;
use App\Processor\RedisProcessor;
use App\Producer\RedisProducer;
use App\Repository\RequestRepository;
use App\UseCase\CreateRequestUseCase;
use Doctrine\DBAL\DriverManager;
use Silex\Application;
use Predis\Client as RedisClient;

$app = new Application();

$app['redis'] = static function () {
    return new RedisClient([
        'scheme' => 'tcp',
        'host' => getenv('REDIS_HOST'),
        'port' => getenv('REDIS_PORT'),
    ]);
};

$app['db'] = static function () {
    return DriverManager::getConnection([
        'dbname' => getenv('MYSQL_DATABASE'),
        'user' => getenv('MYSQL_USER'),
        'password' => getenv('MYSQL_PASSWORD'),
        'host' => getenv('MYSQL_CONTAINER_NAME'),
        'driver' => 'pdo_mysql',
    ]);
};

$app['request.repository'] = static fn($app) => new RequestRepository($app['db']);
$app['producer.interface'] = static fn($app) => new RedisProducer($app['redis']);
$app['request.consumer'] = static fn($app) => new RequestConsumer($app['request.repository']);
$app['create.request.use.case'] = static fn($app) => new CreateRequestUseCase($app['producer.interface'], $app['request.repository']);
$app['create.request.controller'] = static fn($app) => new CreateRequestController($app['create.request.use.case']);
$app['request.status.controller'] = static fn($app) => new RequestStatusController($app['request.repository']);
$app['processor.interface'] = static fn($app) => new RedisProcessor($app['redis'], $app['request.consumer']);

return $app;
