<?php

echo '<h1>Hello world! ' . date('Y-m-d h:i:s') . '</h1>';

ini_set('display_errors', 'on');


// check mysql
try {
    $dsn = 'mysql:host=' . getenv('MYSQL_HOST') . ';';
    $dsn .= 'dbname=' . getenv('MYSQL_DATABASE');

    $pdo = new PDO(
        $dsn,
        getenv('MYSQL_USER'),
        getenv('MYSQL_PASSWORD')
    );
    echo 'Database connection: successful</br>';
} catch (\Throwable $e) {
    echo 'Database connection: error. ' . $e->getMessage() . '</br>';
}

// check memcache
try {
    $memcached = new Memcache();
    $memcached->addServer(getenv('MEMCACHED_HOST'), getenv('MEMCACHED_PORT_IN'));
    $memcached->set('key', 12);

    if (!empty($memcached->get('key'))) {
        echo 'Memcached connection: successful</br>';
    } else {
        echo 'Memcached connection: error</br>';
    }
} catch (\Throwable $e) {
    echo 'Memcached connection: error. ' . $e->getMessage() . '<br>';
}

// check redis
try {
    $redis = new Redis();
    $redis->connect(getenv('REDIS_HOST'), getenv('REDIS_PORT_IN'));

    echo 'Redis connection: successful. Ping: ' . $redis->ping() . '<br>';
} catch (\Throwable $e) {
    echo 'Redis connection: error. ' . $e->getMessage() . '<br>';
}

phpinfo();
