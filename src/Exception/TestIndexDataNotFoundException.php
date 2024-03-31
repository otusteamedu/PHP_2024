<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class TestIndexDataNotFoundException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Отсутствует путь к тестовым данным индекса ELASTICSEARCH_DATA_PATH', 400, $previous);
    }
}
