<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Exception;

use RuntimeException;
use Throwable;

class CommandNotFoundException extends RuntimeException
{
    public function __construct(string $commandName, ?Throwable $previous = null)
    {
        parent::__construct("Команда $commandName не найдена", 0, $previous);
    }
}
