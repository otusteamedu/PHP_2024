<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class SocketWriteFailedException extends RuntimeException
{
    public function __construct(string $errReason, ?Throwable $previous = null)
    {
        parent::__construct('Ошибка при записи в сокет (socket_write): ' . $errReason, 1, $previous);
    }
}
