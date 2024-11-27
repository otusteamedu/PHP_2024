<?php

require __DIR__ . '/../vendor/autoload.php';

use Predis\Client;
use App\EventManager;
use App\Storage\RedisStorage;

$config = require __DIR__ . '/config.php';
$redisClient = new Client($config['redis']);

$storage = new RedisStorage($redisClient);
return new EventManager($storage);

