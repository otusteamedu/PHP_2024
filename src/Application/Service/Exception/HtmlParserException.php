<?php

declare(strict_types=1);

namespace App\Application\Service\Exception;

use RuntimeException;
use Throwable;

class HtmlParserException extends RuntimeException
{
    public function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
