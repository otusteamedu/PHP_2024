<?php

declare(strict_types=1);

require_once "../../vendor/autoload.php";

use RailMukhametshin\Hw\Requests\StringRequest;

$request = new StringRequest();

try {
    if ($request->isPost() === false) {
        http_response_code(403);
        throw new Exception('Method not allowed');
    }

    if ($request->isEmptyString()) {
        http_response_code(400);
        throw new Exception('String is empty');
    }

    if (!$request->isValidString()) {
        http_response_code(400);
        throw new Exception('String is not valid');
    }

    http_response_code(200);
    echo json_encode([
        'result' => 'ok',
        'hostname' => $_SERVER['HOSTNAME']
    ]);
} catch (Exception $exception) {
    echo json_encode([
        'message' => $exception->getMessage()
    ]);
}
