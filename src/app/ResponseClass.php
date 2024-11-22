<?php

namespace App;

class ResponseClass
{
    /**
     * @param string $message
     * @param int $statusCode
     * @return string
     */
    public static function makeResponse(string $message, int $statusCode): string
    {
        $requestProtocol = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0';

        header('Content-type: application/json');
        header($requestProtocol . ' ' . $statusCode . ' ' . $message);

        return json_encode([
            'message' => $message,
            'code' => $statusCode,
            'server_name' => $_SERVER['HOSTNAME'],
            'session_id' => session_id(),
        ]);
    }

    /**
     * @param string $message
     * @param int $statusCode
     */
    public static function sendResponse(string $message, int $statusCode = 200): void
    {
        echo static::makeResponse($message, $statusCode);
    }
}
