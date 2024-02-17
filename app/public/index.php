<?php

use App\Exceptions\ValidatorException;
use App\Validators\StringValidator;

require '../../vendor/autoload.php';

$memcached = new App\Services\MemcachedService('../../.env');

session_start();

//hw4 Задание 1
$validator = new StringValidator('string');
try {
    $validator->validate();
} catch (ValidatorException $e) {
}

//hw4 Задание 2 Проверка отработки баланисировщика Nginx
$memcached->getSessionId();
echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . '<br>';
echo "Запрос обработал сервер nginx c IP: " . $_SERVER['SERVER_ADDR'] . '<br>';
