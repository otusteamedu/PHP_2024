<?php

declare(strict_types=1);

namespace App\Application\Exception;

use RuntimeException;
use Throwable;

class FailedToLoadHtmlContent extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        // Объединить с PageTitle
        parent::__construct('Не удалось прочитать содержимое страницы', 400, $previous);
    }
}
