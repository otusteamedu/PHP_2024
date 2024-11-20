<?php

// start session
session_start();

// Метод запроса
$requestMethod = $_SERVER['REQUEST_METHOD'];

$responseCode = 422;
$responseMessage = 'Unprocessable Entity';

if ($requestMethod === 'POST') {
    $requestBody = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (
        !is_array($requestBody) ||
        !array_key_exists('string', $requestBody) ||
        empty($requestBody['string']) ||
        !is_string($requestBody['string'])
    ) {
        exit(makeResponse($responseMessage, $responseCode));
    }

    $requestStringParam = $requestBody['string'];

    $openBracketsCount = preg_match_all('/\(/', $requestStringParam, $openBracketsMatches);

    $closeBracketsCount = preg_match_all('/\)/', $requestStringParam, $closeBracketsMatches);

    if (!$openBracketsCount || !$closeBracketsCount || $openBracketsCount !== $closeBracketsCount) {
        $responseMessage = 'Brackets count mismatch';
        exit(makeResponse($responseMessage, $responseCode));
    }

    $responseCode = 200;
    $responseMessage = 'OK';
}

exit(makeResponse($responseMessage, $responseCode));


/**
 * @param string $message
 * @param int $statusCode
 * @return string
 */
function makeResponse(string $message, int $statusCode = 200): string
{
    $requestProtocol = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0';

    header('Content-type: application/json');
    header($requestProtocol . ' ' . $statusCode . ' ' . $message);

    return json_encode([
        'message' => $message,
        'code' => $statusCode,
        'session_id' => session_id(),
    ]);
}
