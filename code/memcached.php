<?php

error_reporting(E_ALL|E_STRICT);

ini_set('display_errors', true);
$mem = new memcached();
$mem->addServer("memcached",11211);
$result = $mem->get("Test");
if ($result) {
    echo $result;
} else {
    echo "Тестовый ключ не найден, добавляю... Обновите страницу.";
    $mem->set("Test", "Ключ найден, memcached работает") or die("Не получилось...");
}
