<?php

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

// Проверка состояния сервера
$status = $memcached->getStats();
if ($status) {
    echo "Connected to Memcached server.<br>\n";
} else {
    echo "Failed to connect to Memcached server.<br>\n";
}

// Установка значения в кэш
$setResult = $memcached->set('key', 'Hello, Memcached!', 60); // 60 секунд

if ($setResult) {
    echo "Value successfully set in cache.<br>\n";
} else {
    echo "Failed to set value in cache.<br>\n";
}

// Получение значения из кэша
$value = $memcached->get('key');
if ($value) {
    echo $value; // Выводит "Hello, Memcached!"
} else {
    echo "Нет данных в кэше.\n";
    $resultCode = $memcached->getResultCode();
    echo "Error code: " . $resultCode . "\n";
}
