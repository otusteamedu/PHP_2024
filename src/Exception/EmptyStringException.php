<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class EmptyStringException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Нет данных для проверки', 400, $previous);
    }
}
