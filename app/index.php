<?php

echo '<div style="text-align:center">';

echo 'MySQL: <br>';
try {
    $mysql = new PDO('mysql:host=mysql;dbname=database', 'dbuser', 'secret');
    echo $mysql->getAttribute(PDO::ATTR_CONNECTION_STATUS);
} catch (Throwable $e) {
    echo $e->getMessage();
}

echo '<hr>Redis: <br>';
try {
    $redis = new Redis();
    $redis->connect('redis', 6379);
    echo 'version: ' . $redis->info()['redis_version'] . '<br>';
} catch (Throwable $e) {
    echo $e->getMessage();
}

echo '<hr>Memcached: <br>';
try {
    $memcached = new Memcached();
    $memcached->addServer('memcached', 11211);
    echo 'version: ' . implode(',', $memcached->getVersion());
} catch (Exception $e) {
    echo $e->getMessage();
}

echo '<br>';

echo '</div>';

echo phpinfo();
