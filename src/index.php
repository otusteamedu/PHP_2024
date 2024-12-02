<?php

require 'vendor/autoload.php';
require 'CheckerBracket.php';

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);

if (empty($data) || !isset($data['string'])) {
    response([
        'status' => 'ERROR',
        'message' => 'Ожидается POST запрос с параметром string',
        'code' => 400
    ]);

    return;
}

$checkerBracket = new CheckerBracket();

try {
    $isChecked = $checkerBracket->ckeckBrackets($data['string']);
    $result = [
        'status' => 'OK',
        'message' => 'Все хорошо',
        'code' => 200
    ];
} catch (Exception $e) {
    $result = [
        'status' => 'ERROR',
        'message' => $e->getMessage(),
        'code' => 400
    ];
}

response($result);

function response($result): void
{
    http_response_code($result['code']);
    header('Content-type: application/json');

    echo json_encode([
        'status' => $result['status'],
        'message' => $result['message'],
        'code' => $result['code'],
        'count_views' => getCountViews()
    ]);

}

function getCountViews()
{
    $redisClient = getClientRedis();
    $count = ($redisClient->get('count') ?? 0) + 1;
    $redisClient->set('count', $count);

    return $count;
}

function getClientRedis()
{
    return new \Predis\Client(
        [
            ["host" => "otus-redis-1", "port" => 6381],
            ["host" => "otus-redis-2", "port" => 6382],
            ["host" => "otus-redis-3", "port" => 6383],
            ["host" => "otus-redis-4", "port" => 6384],
            ["host" => "otus-redis-5", "port" => 6385],
            ["host" => "otus-redis-6", "port" => 6386]
        ],
        ['cluster' => 'redis']
    );
}

