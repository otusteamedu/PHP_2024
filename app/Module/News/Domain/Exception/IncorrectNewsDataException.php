<?php

declare(strict_types=1);

namespace Module\News\Domain\Exception;

use DomainException;
use Throwable;

final class IncorrectNewsDataException extends DomainException
{
    public function __construct(array $data, int $code = 0, ?Throwable $previous = null)
    {
        $params = implode(", ", array_keys($data));
        parent::__construct("Expected id, url, title and date params, passed '$params'", $code, $previous);
    }
}
