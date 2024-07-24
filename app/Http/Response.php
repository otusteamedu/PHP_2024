<?php

namespace App\Http;

/**
 * Response class.
 */
class Response
{
    /**
     * @param array $data
     * @param int $statusCode
     */
    public function __construct(public array $data = [], public int $statusCode = 200)
    {
    }

    /**
     * Send the response with the appropriate headers.
     *
     * @return void
     */
    public function send(): void
    {
        header('Content-Type: application/json');

        http_response_code($this->statusCode);

        echo json_encode($this->data);
    }
}
