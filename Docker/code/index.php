<?php
require "StringAnalyzer.php";

if ($_POST['string'] !== "") {
    $string = $_POST['string'];
} else {
    http_response_code(400);
    throw new \RuntimeException("Строка не найдена в POST запросе", 400);
}

header("Content-Type: application/json");
$StringAnalyzer = new StringAnalyzer();

$response = $StringAnalyzer->checkBrackets($string);
$container = $_SERVER['HOSTNAME'];

$redis = new Redis();

try {
    $redis->connect('redis', 6379);
    $redisConnect = true;
} catch (RedisException $e) {
    $redisConnect = false;
}

if ($response) {
    $data = [
        'RedisConnect' => $redisConnect,
        'success' => true,
        'message' => "Строка корректна",
        'Контейнер' => $container
    ];
    http_response_code(200);
} else {
    $data = [
        'success' => false,
        'message' => "Строка некорректна",
        'Контейнер' => $container
    ];
    http_response_code(400);
}


echo json_encode($data);



