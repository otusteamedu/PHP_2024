<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class ElkRedStatusException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Статус кластера: red. Поиск не представляется возможным.', 400, $previous);
    }
}
