<?php

$memcached = new Memcached();
$memcached->addServer("memcached", 11211);
$memcached->add("mc_state", "OK");
echo "memcached: " . ($memcached->get("mc_state") ?? "ошибка подключения");
echo "<br>";

$redis = new Redis();
$redis->connect('redis');
if ($redis->ping()) {
    echo "redis, подключились и пинг есть";
} else {
    echo "redis: не удалось подключиться";
}
echo "<br>";

$mysql = new mysqli('mysql', 'otus', '123', null, null, "/usr/local/var/run/php-fpm.sock");
if ($mysql->connect_error) {
    echo "mysql: ошибка подключения : " . $mysql->connect_error;
} else {
    echo "mysql подключен";
    echo "<br>";
}
