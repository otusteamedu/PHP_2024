<?php

namespace App;

class ValidationClass
{
    /**
     * @param array $requestBody
     * @return bool
     */
    public static function validateRequestBody(array $requestBody): bool
    {
        if (!array_key_exists('string', $requestBody) || empty($requestBody['string']) || !is_string($requestBody['string'])) {
            return false;
        }

        return true;
    }

    /**
     * @param string $requestString
     * @return bool
     */
    public static function validateRequestString(string $requestString): bool
    {
        $openBracketsCount = preg_match_all('/\(/', $requestString, $openBracketsMatches);
        $closeBracketsCount = preg_match_all('/\)/', $requestString, $closeBracketsMatches);

        if (!$openBracketsCount || !$closeBracketsCount || $openBracketsCount !== $closeBracketsCount) {
            return false;
        }

        return true;
    }
}