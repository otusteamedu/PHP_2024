<?php

namespace App\Http;

class Response
{
    public function __construct(public array $data = [], public int $statusCode = 200)
    {
    }

    public function send(): void
    {
        header('Content-Type: application/json');

        http_response_code($this->statusCode);

        echo json_encode($this->data);
    }
}