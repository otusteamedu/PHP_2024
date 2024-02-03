<?php

namespace Dotenv;
use PDO;
use Redis;
use Memcached;

// Загрузка переменных окружения из файла .env
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Получение переменных окружения
$dbUser = $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME');
$dbName = $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE');
$dbPassword = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD');
$dbHost = $_ENV['DB_HOST'] ?? getenv('DB_HOST');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPassword, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$redis = new Redis();

$redisHost = $_ENV['REDIS_HOST'] ?? getenv('REDIS_HOST');
$redisPort = $_ENV['REDIS_PORT'] ?? getenv('REDIS_PORT');

try {
    $redis->connect($redisHost, $redisPort);
    // Устанавливаем значение
    $redis->set("testKey", "Hello Redis");
    // Получаем значение
    echo $redis->get("testKey");
} catch (Exception $e) {
    echo "Ошибка подключения к Redis: ".$e->getMessage();
}

$memcached = new Memcached();
$hostMem = $_ENV['MEM_HOST'] ?? getenv('MEM_HOST');
$portMem = $_ENV['MEM_PORT'] ?? getenv('MEM_PORT');

$memcached->addServer($hostMem, $portMem);

// Устанавливаем значение
$memcached->set("testKey", "Hello Memcached");

// Получаем значение
echo $memcached->get("testKey");

echo "<link rel='stylesheet' href='style.css'>";