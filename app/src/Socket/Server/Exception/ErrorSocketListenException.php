<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Socket\Server\Exception;

class ErrorSocketListenException extends \Exception
{
    public function __construct(
        string $error,
        int $code = 0,
        \Throwable $previous = null
    ) {
        $message = 'Failed to listen socket: ' . $error;
        parent::__construct($message, $code, $previous);
    }
}
