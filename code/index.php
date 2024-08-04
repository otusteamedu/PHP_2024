<?php

echo "Привет, Otus!<br>" . date("Y-m-d H:i:s") . "<br><br>";

echo "Проверяем Redis: ";

$redis = new Redis();
$redis->connect('redis', 6379);

echo $redis->ping('Redis is OK') . "<br />";

echo "Проверяем Memcached: ";

$mem = new Memcached();
$mem->addServer("memcached", 11211);
$result = $mem->get("Test");
if ($result) {
    echo $result . "<br />";
} else {
    echo "Тестовый ключ не найден, добавляю... Обновите страницу.";
    $mem->set("Test", "Ключ найден, memcached работает") or die("Не получилось...");
}

echo "Проверяем MySQL: ";

$link = mysqli_connect("mysql", "root", "Qwerty12@@");

if ($link === false) {
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
} else {
    print("Соединение установлено успешно");
}
