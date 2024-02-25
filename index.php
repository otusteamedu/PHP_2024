<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;


echo "Привет, Otus!<br>" . date("Y-m-d H:i:s") . "<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];

/*
 * ToDo:
 *  1) Образ nginx-upstream-only на другие два nginx контейнера
 *  2) Образ ngnix-upstream-to-php на два php-fpm контейнера
 *  3) Образ memcached и postgres возможно как кластера
 */
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// redis data
$redisHost = $_ENV['REDIS_HOST'] ?? null;
$redisPort = $_ENV['REDIS_PORT'] ?? null;

try {
    $redis = new Redis();
    $redis->connect($redisHost, $redisPort);
    echo "Соединение с Redis успешно установлено.<br>";
} catch (Exception $e) {
    echo "Ошибка подключения к Redis: " . $e->getMessage();
}
//// memcached connection check
//try {
//    $memcached = new Memcached();
//    $memcached->addServer($memcachedHost, $memcachedPort);
//    echo "Соединение с Memcached успешно установлено.<br>";
//} catch (Exception $e) {
//    echo "Ошибка подключения к Memcached: " . $e->getMessage();
//}

phpinfo();
