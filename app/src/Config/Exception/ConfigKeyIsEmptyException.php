<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config\Exception;

class ConfigKeyIsEmptyException extends \Exception
{
    public function __construct(
        int|string $key,
        int $code = 0,
        \Throwable $previous = null
    ) {
        $message = "Config key '$key' is empty.";
        parent::__construct($message, $code, $previous);
    }
}
