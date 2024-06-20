<?php

declare(strict_types=1);

namespace App\Http;

class Response
{
    public static function json(array $data, int $statusCode = 200): string
    {
        header('Content-Type: application/json');

        http_response_code($statusCode);

        return json_encode($data);
    }
}
