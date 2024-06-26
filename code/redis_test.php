<?php

$redis = new Redis();
$redis->connect('redis', 6379);

// Установка значения в Redis
$redis->set('key', 'Hello, Redis!');

// Получение значения из Redis
$value = $redis->get('key');
if ($value) {
    echo $value; // Выводит "Hello, Redis!"
} else {
    echo "Нет данных в Redis.";
}
