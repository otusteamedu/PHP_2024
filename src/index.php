<?php

echo "<h1>Проверка соединения</h1>";

// Проверка подключения к PostgreSQL
$dsn = 'pgsql:host=postgres;port=5432;dbname=database';
$user = 'user';
$password = 'password';

try {
    $dbh = new PDO($dsn, $user, $password);
    echo "<p>PostgreSQL connected successfully!</p>";
} catch (PDOException $e) {
    echo "<p>PostgreSQL connection failed: " . $e->getMessage() . "</p>";
}


// Проверка подключения к Redis
try {
    $redis = new Redis();
    $redis->connect('redis', 6379);
    echo "<p>Redis connected successfully!</p>";
} catch (Exception $e) {
    echo "<p>Redis connection failed: " . $e->getMessage() . "</p>";
}

// Проверка подключения к Memcached
$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

if ($memcached->set('test_key', 'test_value')) {
    echo "<p>Memcached connected successfully!</p>";
} else {
    echo "<p>Memcached connection failed!</p>";
}
