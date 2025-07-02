<?php

require_once __DIR__ . '/code/vendor/autoload.php';

use VKomar\StringValidation;

$validation = new StringValidation();
$validation->checkString();

/*
echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . "<br>";

$redis = new Redis();
$redis->connect('redis');

$redis->set('test', 'Hello Redis');
echo $redis->get('test');
*/
