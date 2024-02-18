<?php

use App\Exceptions\ValidatorException;
use App\Validators\StringValidator;

require '../../vendor/autoload.php';

$memcached = new App\Services\MemcachedService('../../.env');

session_start();

//hw4 Задание 1
$validator = new StringValidator('string');
try {
    header('HTTP/1.1 ' . 200);
    echo $validator->validate();
} catch (ValidatorException $e) {
    header('HTTP/1.1 ' . 422);
    echo $e->withMessage();
}

//hw4 Задание 2 Проверка отработки баланисировщика Nginx
echo 'Session id: ' . session_id() . '<br>';
echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . '<br>';
echo "Запрос обработал сервер nginx c IP: " . $_SERVER['SERVER_ADDR'] . '<br>';
