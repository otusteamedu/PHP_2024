<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class NonExistedConfigException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Отсутствует ini файл конфигураций', 400, $previous);
    }
}
