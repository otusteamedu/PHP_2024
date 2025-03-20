<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

echo "Hello from PHP-FPM!<br>";

// Проверка подключения к Redis
$redis = new Redis();
$redis->connect('redis', 6379);
echo "Connected to Redis: " . ($redis->ping() ? "Yes" : "No") . "<br>";

// Проверка подключения к Memcached
$memcached = new Memcached();
$memcached->addServer('memcached', 11211);
echo "Connected to Memcached: " . ($memcached->set('test', 'Hello Memcached') ? "Yes" : "No") . "<br>";

// Проверка подключения к PostgreSQL
try {
    $host = 'postgres';   // MySQL server hostname within the same Docker network
    $user = $_SERVER['POSTGRES_USER'];    // MySQL username
    $pass = $_SERVER['POSTGRES_PASSWORD'];   // MySQL password
    $db = $_SERVER['POSTGRES_DB'];// MySQL database name

    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    echo "Connected to PostgreSQL: Yes<br>";
} catch (PDOException $e) {
    echo "Connected to PostgreSQL: No<br>";
}

phpinfo();
