<?php

declare(strict_types=1);

use App\Infrastructure\Repository\RedisRepository;
use DI\Container;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$config = require __DIR__ . '/config.php';

$container = new Container();

$container->set('config', $config);
$redis = new Redis();
$container->set('redisRepository', function () use ($config) {
    if (empty($config['redis'])) {
        throw new Exception('Redis configuration not set');
    }
    $redisConfig = $config['redis'];

    $redis = new Redis();
    $redis->connect(
        $redisConfig['host'],
        $redisConfig['port'],
        $redisConfig['connectTimeout']
    );
    $redisRepository = new RedisRepository($redis);
    return $redisRepository;
});

AppFactory::setContainer($container);

$app = AppFactory::create();

return $app;
