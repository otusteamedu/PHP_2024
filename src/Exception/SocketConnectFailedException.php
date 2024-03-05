<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class SocketConnectFailedException extends RuntimeException
{
    public function __construct(string $errReason, ?Throwable $previous = null)
    {
        parent::__construct(
            'Ошибка при соединении с сокетом (socket_connect): ' . $errReason,
            1,
            $previous
        );
    }
}
