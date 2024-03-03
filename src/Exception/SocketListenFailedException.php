<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class SocketListenFailedException extends RuntimeException
{
    public function __construct(string $errReason, ?Throwable $previous = null)
    {
        parent::__construct('Ошибка при прослушивании сокета (socket_listen): ' . $errReason, 1, $previous);
    }
}
