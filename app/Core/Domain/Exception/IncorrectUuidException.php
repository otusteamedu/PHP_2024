<?php

declare(strict_types=1);

namespace Core\Domain\Exception;

use DomainException;
use Throwable;

final class IncorrectUuidException extends DomainException
{
    public function __construct(string $uuid, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Trying to use incorrect string '$uuid' as uuid", $code, $previous);
    }
}
