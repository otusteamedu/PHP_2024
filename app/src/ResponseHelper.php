<?php

namespace Otus\Hw4;

class ResponseHelper
{
    /**
     * @param int $responseCode
     * @return int|bool
     */
    public static function sendResponse(int $responseCode = 0): int|bool
    {
        return http_response_code($responseCode);
    }
}
