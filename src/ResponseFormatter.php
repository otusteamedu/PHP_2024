<?php

namespace ResponseFormatter;

class ResponseFormatter
{
    public static function jsonResponse(array $data, int $statusCode): string
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        return json_encode($data, JSON_THROW_ON_ERROR);
    }
}