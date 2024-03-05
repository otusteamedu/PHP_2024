<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class InvalidAppTypeException extends RuntimeException
{
    public function __construct(string $appType, ?Throwable $previous = null)
    {
        parent::__construct('Некорректный тип приложение ' . $appType, 1, $previous);
    }
}
