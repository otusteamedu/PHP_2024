<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config\Exception;

class ConfigSectionNotFoundException extends \Exception
{
    public function __construct(
        string $configSection,
        int $code = 0,
        \Throwable $previous = null
    ) {
        $message = "Config section '$configSection' not found.";
        parent::__construct($message, $code, $previous);
    }
}
