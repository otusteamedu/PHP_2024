<?php

$memcached = new Memcached();
$memcached->addServer("memcached", 11211);
$memcached->add("mc_state", "OK");
echo "memcached: " . ($memcached->get("mc_state") ? "подключено" : "ошибка подключения");
echo "<br>";

$redis = new Redis();
$redis->connect('redis');
echo "redis: " . ($redis->ping() ? "подключено" : "ошибка подключения");
echo "<br>";

$mysql = new mysqli('mysql', 'otus', '123', null, null, "/usr/local/var/run/php-fpm.sock");
echo "mysql: " . (empty($mysql->connect_error) ? " подключено" : "ошибка подключения");
echo "<br>";
