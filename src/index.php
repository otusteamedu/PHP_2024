<?php

$redis = new Redis();
$redis->connect('redis', 6379);
echo $redis->ping('Redis: ok') ?: 'Redis: error';
echo '<br>';

$memcached = new Memcached();
$memcached->addServer('otusphp_memcached', 11211);
echo $memcached->getStats()
    ? 'Memcached: ok'
    : 'Memcached: error';
echo '<br>';

try {
    $pdo = new PDO(
        'mysql:host=otusphp_db;dbname=otusphp',
        'root',
        'root'
    );
    echo 'DB: ok';
} catch (Exception $e) {
    echo 'DB: error';
}
