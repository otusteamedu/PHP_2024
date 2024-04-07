<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class EmptyActionNameException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Не передано имя используемой команды', 0, $previous);
    }
}
