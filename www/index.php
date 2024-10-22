<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mysqli = new mysqli('mysql', 'root', $_ENV['MYSQL_ROOT_PASSWORD']);

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

$redis = new Redis();
$redis->connect('redis', 6379);

echo "<pre>";
var_dump('<b>mysqli:</b>', $mysqli->get_server_info());
var_dump('<b>memcached:</b>', json_encode($memcached->getVersion()));
var_dump('<b>redis:</b>', json_encode($redis->info()));
echo "</pre>";
