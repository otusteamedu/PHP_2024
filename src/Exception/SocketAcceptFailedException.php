<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class SocketAcceptFailedException extends RuntimeException
{
    public function __construct(string $errReason, ?Throwable $previous = null)
    {
        parent::__construct(
            'Ошибка при принятии входящего сообщения сокета(socket_accept): ' . $errReason,
            1,
            $previous
        );
    }
}
