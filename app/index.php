<?php

echo 'it works!<br>' . date('Y-m-d H:i:s') . '<br>';

$redis = new Redis();
$connect = $redis->connect('redis');
echo ($connect ? 'Redis: коннект установлен' : 'Redis: коннект отсутсвует') . '<br>';

$auth = $redis->auth($_ENV['REDIS_PASSWORD']);
echo ($auth ? 'Redis: авторизация выполнена' : 'Redis: в доступе отказано') . '<br>';

$redis->publish('redis-test', json_encode(['test' => 'success']));

$redis->close();

phpinfo();
