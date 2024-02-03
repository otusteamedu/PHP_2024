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
echo 'Redis connect ping - ' . $redisService->ping();

$memcached = new \classes\Memcached(
    getenv('MEMCACHED_HOST'),
    getenv('MEMCACHED_PORT')
);
echo 'Memcached version - ' . $memcached->ping();


echo "Hello World!";
