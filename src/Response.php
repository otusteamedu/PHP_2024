<?php

namespace ValidatorBrackets;

class Response
{
    public static function answer($message, $error = false)
    {
        if ($error) {
            http_response_code(400);
        }
        return print_r($message);
    }
}
