<?php

require 'vendor/autoload.php';

echo "<h1>Тестирование Redis...</h1>";
try {
    $redis = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => 'redis',
        'port'   => 6379,
    ]);

    if ($redis->ping()) {
        echo "Redis PONG!<br>";
    }
} catch (Exception $e) {
    echo "Соединение с Redis не удалось: " . $e->getMessage();
}

echo "<h1>Тестирование Memcached...</h1>";
try {
    $mem = new Memcached();
    $mem->addServer('memcached', 11211);
    $mem->set('key', 'Hello, Memcached!');
    if ($mem->get('key')) {
        echo $mem->get('key');
    }
} catch (Exception $e) {
    echo "Соединение с Memcached не удалось: " . $e->getMessage();
}

echo "<h1>Тестирование MySQL...</h1>";

try {
    $conn = new PDO("mysql:host=db;dbname=mydb", "user", "userpassword");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Успешное соединение с MySQL";
} catch(PDOException $e) {
    echo "Соединение с MySQL не удалось: " . $e->getMessage();
}
