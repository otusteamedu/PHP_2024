<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class WrongConfigException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Некорректный ini файл конфигураций', 400, $previous);
    }
}
