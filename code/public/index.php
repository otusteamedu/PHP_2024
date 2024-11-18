<?php

require '../vendor/autoload.php';
require '../config/config.php';

use Database\DatabaseConnection;
use Redis\RedisConnection;
use SessionHandler\SessionHandler;
use String\StringProcessor\StringProcessor;

$config = require '../config/config.php';

$sessionHandler = new SessionHandler();
$sessionHandler->start();

$dbConnection = new DatabaseConnection($config['psql']);
$dbConnection->connect();

$redisConnection = new RedisConnection($config['redis']);
$redisConnection->connect();

$processor = new StringProcessor();
echo 'StringProcessor - ' . $processor->getLength('my string') . "<br>"; //9

echo "Привет, Otus!<br>" . date("Y-m-d H:i:s") . "<br><br>";

phpinfo();
