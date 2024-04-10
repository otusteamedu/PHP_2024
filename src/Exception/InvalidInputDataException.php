<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class InvalidInputDataException extends RuntimeException
{
    public function __construct(string $actionName, ?Throwable $previous = null)
    {
        parent::__construct('Неверные входные данных для операции ' . $actionName, 0, $previous);
    }
}
