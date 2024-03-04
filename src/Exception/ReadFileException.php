<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class ReadFileException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct( 'Ошибка при чтении файла', 400, $previous);
    }
}
