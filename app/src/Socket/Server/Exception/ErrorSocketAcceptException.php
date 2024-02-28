<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Socket\Server\Exception;

class ErrorSocketAcceptException extends \Exception
{
    public function __construct(
        string $error,
        int $code = 0,
        \Throwable $previous = null
    ) {
        $message = 'Failed to accept socket: ' . $error;
        parent::__construct($message, $code, $previous);
    }
}
