<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class EmptyHallException extends RuntimeException
{
    public function __construct(int $hallId, ?Throwable $previous = null)
    {
        parent::__construct("Не найден кинозал с id $hallId", 0, $previous);
    }
}
