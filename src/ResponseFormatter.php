<?php

declare(strict_types=1);

namespace App;

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
     * @return string
     */
    public function sendError(int $statusCode, string $message): string
    {
        http_response_code($statusCode);
        return json_encode(["message" => $message]);
    }

    /**
     * Send a success response.
     *
     * @param int $statusCode HTTP status code
     * @param string $message Success message
     * @return string
     */
    public function sendSuccess(int $statusCode, string $message): string
    {
        http_response_code($statusCode);
        return json_encode(["message" => $message]);
    }
}
