<?php

define("BASE_PATH", __DIR__);
// Composer
require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$redisService = new \classes\RedisService();
$manager = new \classes\Manager($redisService);

echo $manager->checking();

echo "Hello World!";
