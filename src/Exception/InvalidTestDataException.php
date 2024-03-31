<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class InvalidTestDataException extends RuntimeException
{
    public function __construct(string $filePath, ?Throwable $previous = null)
    {
        parent::__construct("Не удалось прочитать данные из файла $filePath", 400, $previous);
    }
}
