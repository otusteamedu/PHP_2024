<?php

declare(strict_types=1);

namespace Module\News\Domain\Exception;

use DomainException;
use Throwable;

final class IncorrectNewsDataTypeException extends DomainException
{
    public function __construct(mixed $data, int $code = 0, ?Throwable $previous = null)
    {
        $type = gettype($data);
        parent::__construct("News data must be an array, $type passed", $code, $previous);
    }
}
