<?php

echo 'Nginx is working, version: ' . $_SERVER['SERVER_SOFTWARE'] . '<br>';
echo "<hr>Test static files: " . '<div><img src="img/picture1.png" style="width: 300px;"></div>';
echo '<hr>PHP-FPM version: ' . phpversion() . '<br>';

echo '<hr>Check Redis connection: <br>';
$redis = new Redis();
$redis->connect('redis', 6379);
echo 'Connection to server successfully<br>';
echo 'Server version: ' . $redis->info()['redis_version'] . '<br>';

echo '<hr>Check Memcached connection: <br>';
$memcached = new Memcached();
$memcached->addServer('memcached', 11211);
try {
    echo 'Connection to server successfully<br>Server version: ' . implode(',', $memcached->getVersion());
} catch (Exception $e) {
    echo 'Connection to server failed<br>';
}

echo '<hr>Check MySQL connection: <br>';
try {
    $mysqli = new mysqli("mysql", "root", "123456");
    echo "Версия сервера: {$mysqli->server_info}<br>";
} catch (Exception $e) {
    echo 'Connection to server failed<br>';
}

