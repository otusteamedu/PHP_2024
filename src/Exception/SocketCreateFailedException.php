<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class SocketCreateFailedException extends RuntimeException
{
    public function __construct(string $errReason, ?Throwable $previous = null)
    {
        parent::__construct('Ошибка при создании сокета: ' . $errReason, 1, $previous);
    }
}
