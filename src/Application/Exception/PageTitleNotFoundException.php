<?php

declare(strict_types=1);

namespace App\Application\Exception;

use RuntimeException;
use Throwable;

class PageTitleNotFoundException extends RuntimeException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('Отсутствует заголовок новостной страницы в теге title', 400, $previous);
    }
}
