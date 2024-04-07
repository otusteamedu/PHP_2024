<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
// postgres data
$host = $_ENV['POSTGRES_DB_HOST'] ?? null;
$db   = $_ENV['POSTGRES_DB_NAME'] ?? null;
$dbPort = $_ENV['POSTGRES_PORT'] ?? null;
$user = $_ENV['POSTGRES_USER'] ?? null;
$pass = $_ENV['POSTGRES_PASSWORD'] ?? null;
// redis data
$redisHost = $_ENV['REDIS_PORT'] ?? null;
$redisPort = $_ENV['REDIS_PORT'] ?? null;
// memcached data
$memcachedHost = $_ENV['MEMCACHED_PORT'] ?? null;
$memcachedPort = $_ENV['MEMCACHED_PORT'] ?? null;

$dsn = "pgsql:host=$host;port=$dbPort;dbname=$db;user=$user;password=$pass";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// postgres connection check
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->exec("SET client_encoding TO 'UTF8';");
    echo "Соединение с базой данных установлено успешно.<br>";
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
// redis connection check
try {
    $redis = new Redis();
    $redis->connect($redisHost, $redisPort);
    echo "Соединение с Redis успешно установлено.<br>";
} catch (Exception $e) {
    echo "Ошибка подключения к Redis: " . $e->getMessage();
}
// memcached connection check
try {
    $memcached = new Memcached();
    $memcached->addServer($memcachedHost, $memcachedPort);
    echo "Соединение с Memcached успешно установлено.<br>";
} catch (Exception $e) {
    echo "Ошибка подключения к Memcached: " . $e->getMessage();
}

phpinfo();
