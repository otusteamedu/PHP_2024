<?php

declare(strict_types=1);

namespace App\Application\Validator;

class Url
{
    public function isValid(string $url): bool
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return true;
    }
}
