<?php

try {
    $redis = new Redis();
    $redis->connect('redis');
    $message = "Redis успешно подключен!<br>";
    $message .= "Redis ping: " . $redis->ping() . "<br>";
    echo $message;
} catch (Exception $e) {
    echo "Ошибка подключения Redis!" . "<br>";
}

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);
$memcached->add("mc_test_connection", "Success");
echo "<br>" . ($memcached->get('mc_test_connection')
        ? "Memcached успешно подключен!"
        : "Ошибка подключения Memcached!"
    ) . "<br>";

try {
    $dsn = "pgsql:host=db;port=5432 dbname=otus2024;";
    $pdo = new PDO($dsn, 'root', 'aA123123', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    if ($pdo) {
        echo "<br> Connected to the otus2024 database successfully!";
    }
} catch (PDOException $e) {
    echo "Ошибка подключения Postgres!" . "<br>";
}



