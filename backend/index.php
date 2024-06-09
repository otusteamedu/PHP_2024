<?php

echo 'php version: '.phpversion().'<br/>';

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

$redisPort = getenv('REDIS_PORT');
$memcachedPort = getenv('MEMCACHE_PORT');

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    $pdo = new PDO($dsn);
    if ($pdo) {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $pdo->query("SELECT version() AS version, current_database() AS database, user AS current_user");
        $info = $query->fetch(PDO::FETCH_ASSOC);
        echo 'PostgreSQL version: ' . $info['version'] . '<br/>';
        echo 'Current database: ' . $info['database'] . '<br/>';
        echo 'Current user: ' . $info['current_user'] . '<br/>';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    $redis = new Redis();
    $redis->connect('redis', $redisPort);

    $redis->set("test_key", "Redis is working");
    $redisValue = $redis->get("test_key");

    echo 'Redis: ' . $redisValue . '<br>';
} catch (Exception $e) {
    echo 'Could not connect to Redis: ' . $e->getMessage() . '<br/>';
}

try {
    $memcached = new Memcached();
    $memcached->addServer('memcached', $memcachedPort);

    $memcached->set('test_key', 'Memcached is working');
    $memcachedValue = $memcached->get('test_key');

    echo 'Memcached: ' . $memcachedValue . '<br/>';
} catch (Exception $e) {
    echo 'Could not connect to Memcached: ' . $e->getMessage() . '<br>';
}
