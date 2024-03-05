<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class WrongInputException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Некорректный ввод. Ожидается два аргумента', 1, $previous);
    }
}
