<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\Exception;

use RuntimeException;
use Throwable;

class BankStatementNotFound extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Банковская выгрузка не обнаружена', 0, $previous);
    }
}
