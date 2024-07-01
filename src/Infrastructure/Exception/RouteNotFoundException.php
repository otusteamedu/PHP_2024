<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Exception;

use RuntimeException;
use Throwable;

class RouteNotFoundException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Ресурс не найден', 0, $previous);
    }
}
