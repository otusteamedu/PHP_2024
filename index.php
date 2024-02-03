<?php

define("BASE_PATH", __DIR__);
// Composer
require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/autoload.php');

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$redisService = new \classes\Redis(
    getenv('REDIS_HOST'),
    getenv('REDIS_PORT')
);

echo 'Redis connection ping - ' . $redisService->ping() . "\r\n";

$memcached = new \classes\Memcached(
    getenv('MEMCACHED_HOST'),
    getenv('MEMCACHED_PORT')
);
echo 'Memcached version - ' . $memcached->ping() . "\r\n";


$mysql = new \classes\Mysql(
    getenv('DB_USERNAME'),
    getenv('DB_PASSWORD'),
    getenv('DB_HOST'),
    getenv('DB_DATABASE')
);
echo 'Mysql connection - ' . $mysql->ping() . "\r\n";

echo "Hello World!";
