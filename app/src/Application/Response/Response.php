<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\Response;

class Response
{
    public static function json($data, $code = 200)
    {
        self::setResponseHeaders($code);
        self::response(json_encode($data));
    }

    private static function response($data)
    {
        echo $data;
    }

    private static function setResponseHeaders($code = 200)
    {
        $message = match ($code) {
            200 => 'OK',
            201 => 'Created',
            404 => 'NOT FOUND',
            500 => 'Unknown Error'
        };

        header('HTTP/1.1 '.$code.' '.$message);
        header('Content-Type: application/json; charset=utf-8');
    }
}
