<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config\Exception;

class ConfigNotFoundException extends \Exception
{
    public function __construct(
        string $message = 'Config file not found.',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
