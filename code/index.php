<?php

// Подключаемся к Redis
$redis = new Redis();
$redis->connect('redis', 6379);

$redis->set('my_key', 'Hello, Redis!!!');
$value = $redis->get('my_key');

echo "Значение из Redis: " . $value;

// Подключаемся к Memcached
$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

$memcached->set('my_key', 'Hello, Memcached!');
$value = $memcached->get('my_key');

echo "Значение из Memcached: " . $value;

phpinfo();