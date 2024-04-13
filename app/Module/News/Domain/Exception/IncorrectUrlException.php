<?php

declare(strict_types=1);

namespace Module\News\Domain\Exception;

use DomainException;
use Throwable;

final class IncorrectUrlException extends DomainException
{
    public function __construct(string $url, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Received $url is not correct url", $code, $previous);
    }
}
