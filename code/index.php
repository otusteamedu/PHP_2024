<?php

try {
    $redis = new Redis();
    $redis->connect(getenv('REDIS_CONTAINER_NAME'), getenv('REDIS_PORT'));

    echo "Redis connection: successful. Ping: " . $redis->ping() . "<br>";
} catch (\Throwable $e) {
    echo "Redis connection: error. " . $e->getMessage() . "<br>";
}

try {
    $memcached = new Memcached();
    $memcached->addServer(getenv('MEMCACHED_CONTAINER_NAME'), getenv('MEMCACHED_PORT'));
    $memcached->set('key', 1);
    if ($memcached->getResultCode() === Memcached::RES_SUCCESS && !empty($memcached->get('key'))) {
        echo "Memcached connection: successful<br>";
    } else {
        echo "Memcached connection: error<br>";
    }
} catch (\Throwable $e) {
    echo "Memcached connection: error. " . $e->getMessage() . "<br>";
}

try {
    $dsn = sprintf("mysql:host=%s;dbname=%s", getenv('MYSQL_CONTAINER_NAME'), getenv('MYSQL_DATABASE'));
    $pdo = new PDO(
        $dsn,
        getenv('MYSQL_USER'),
        getenv('MYSQL_PASSWORD')
    );
    echo "Database connection: successful<br>";
} catch (\Throwable $e) {
    echo "Database connection: error. " . $e->getMessage() . "<br>";
}