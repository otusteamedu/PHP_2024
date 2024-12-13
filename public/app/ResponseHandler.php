<?php

namespace App;

class ResponseHandler
{
    public function sendResponse(int $statusCode, string $message): void
    {
        http_response_code($statusCode);
        echo $message;
    }
}