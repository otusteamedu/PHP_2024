<?php

declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;

/**
 * ResponseFormatter class to format and send responses.
 */
class ResponseFormatter
{
    /**
     * Send an error response.
     *
     * @param int $statusCode HTTP status code
     * @param string $message Error message
     * @return void
     */
    #[NoReturn] public function sendError(int $statusCode, string $message): void
    {
        http_response_code($statusCode);
        echo json_encode(["message" => $message]);
        exit;
    }

    /**
     * Send a success response.
     *
     * @param int $statusCode HTTP status code
     * @param string $message Success message
     * @return void
     */
    #[NoReturn] public function sendSuccess(int $statusCode, string $message): void
    {
        http_response_code($statusCode);
        echo json_encode(["message" => $message]);
        exit;
    }
}
