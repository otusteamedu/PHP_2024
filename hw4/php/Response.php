<?php

class Response
{
    public static function error($code, $message)
    {
        http_response_code($code);
        return $message;
    }

    public static function success($message)
    {
        http_response_code(200);
        return $message;
    }
}
