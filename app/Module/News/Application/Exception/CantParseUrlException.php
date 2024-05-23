<?php

declare(strict_types=1);

namespace Module\News\Application\Exception;

use RuntimeException;
use Throwable;

final class CantParseUrlException extends RuntimeException
{
    public function __construct(string $url, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Could not parse passed url '$url'", $code, $previous);
    }
}
