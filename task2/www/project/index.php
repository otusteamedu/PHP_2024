<?php

declare(strict_types=1);
session_start();

echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . "<br>";

$redis = new Redis();

$redis->connect('redis', 6379);

$_SESSION['name'] = 'otus';
echo $_SESSION['name'];