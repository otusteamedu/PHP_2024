<?php

namespace App;

class RequestValidationClass
{
    /**
     * @param array|null $requestBody
     * @param string $param
     * @return bool
     */
    public static function validateRequestBody(?array $requestBody, string $param): bool
    {
        if (empty($requestBody) || !array_key_exists($param, $requestBody) || empty($requestBody[$param])) {
            return false;
        }

        return true;
    }
}
