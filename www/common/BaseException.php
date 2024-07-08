<?php

declare(strict_types=1);

class BaseException extends Exception
{
    public static function error(string $message, int $code = 400): static
    {
        http_response_code($code);
        return new static($message, $code);
    }
}