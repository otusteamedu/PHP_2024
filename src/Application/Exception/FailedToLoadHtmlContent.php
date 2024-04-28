<?php

declare(strict_types=1);

namespace App\Application\Exception;

use RuntimeException;
use Throwable;

class FailedToLoadHtmlContent extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Не удалось прочитать содержимое страницы', 400, $previous);
    }
}
