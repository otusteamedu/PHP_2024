<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Socket\Abstract\Exception;

class ErrorSocketCreateException extends \Exception
{
    public function __construct(
        string $error,
        int $code = 0,
        \Throwable $previous = null)
    {
        $message = 'Failed to create socket: ' . $error;
        parent::__construct($message, $code, $previous);
    }
}
