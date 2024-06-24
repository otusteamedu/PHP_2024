<?php

namespace ValidatorBrackets;

use Exception;

class Response
{
    public static function answer($message, $error = false)
    {
        if ($error) {
            throw new Exception($message, 400);
        }
        return print_r($message);
    }
}
