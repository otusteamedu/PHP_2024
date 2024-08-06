<?php

$memcached = new Memcached();
$memcached->addServer("memcached", 11211);
$memcached->add("mc_state", "OK");
echo "memcached: " . ($memcached->get("mc_state") ?? "ошибка подключения");
echo "<br>";

try {
    $redis = new Redis();
    $redis->connect('redis');
    echo "redis, подключились и пинг: " . $redis->ping();
    echo "<br>";
} catch(Exception $e) {
    echo "redis: не удалось подключиться";
    echo "<br>";
}

$mysql = new mysqli('mysql', 'otus', '123', null, null, "/usr/local/var/run/php-fpm.sock");
if ($mysql->connect_error) {
    echo "mysql: ошибка подключения : " . $mysql->connect_error;
} else {
    echo "mysql подключен";
    echo "<br>";
}
