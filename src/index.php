<?php

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../';

// Composer
require($dirEnv . 'vendor/autoload.php');
require($dirEnv . 'autoload.php');

$dotenv = \Dotenv\Dotenv::createUnsafeImmutable($dirEnv);
$dotenv->load();

$memcached = new \classes\Memcached(
    getenv('MEMCACHED_HOST'),
    getenv('MEMCACHED_PORT')
);
echo 'Memcached version - ' . $memcached->ping() . "\r\n";

echo "Hello World!";
