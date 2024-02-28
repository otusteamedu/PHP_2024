<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config\Exception;

class SocketConstantNotFoundException extends \Exception
{
    public function __construct(
        string $key,
        int|string $value,
        int $code = 0,
        \Throwable $previous = null
    ) {
        $message = "Socket constant '$value' for '$key' not found.";
        parent::__construct($message, $code, $previous);
    }
}
