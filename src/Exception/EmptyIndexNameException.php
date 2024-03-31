<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use Throwable;

class EmptyIndexNameException extends \RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Для поиска необходимо указать имя индекса', 400, $previous);
    }
}
