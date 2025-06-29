<?php

require 'StringValidation.php';

$string = $_POST['string'] ?? '';

$validation = new VKomar\StringValidation();

header('Content-Type: application/json');
try {
    echo $validation->checkString($string);
} catch (\Exception $exception) {
    http_response_code(400);
    echo json_encode([
        'status' => 'ERROR',
        'message' => $exception->getMessage(),
        'code' => 400,
    ]);
}

/*
echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . "<br>";

$redis = new Redis();
$redis->connect('redis');

$redis->set('test', 'Hello Redis');
echo $redis->get('test');
*/
