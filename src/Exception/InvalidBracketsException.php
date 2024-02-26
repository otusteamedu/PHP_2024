<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class InvalidBracketsException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Количество открывающих и закрывающих скобочек не совпадает', 400, $previous);
    }
}
