<?php

session_start();
$_SESSION['count'] = ($_SESSION['count'] ?? 1) + 1;

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
        'session_count' => $_SESSION['count']
    ]);

}

