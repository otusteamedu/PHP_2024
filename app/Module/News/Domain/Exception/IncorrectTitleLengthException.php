<?php

declare(strict_types=1);

namespace Module\News\Domain\Exception;

use DomainException;
use Throwable;

final class IncorrectTitleLengthException extends DomainException
{
    public function __construct(string $title, int $min, int $max, int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf(
            'Length of title must be more than %d and less than %d, but given %s has %d length',
            $min,
            $max,
            $title,
            mb_strlen($title)
        );
        parent::__construct($message, $code, $previous);
    }
}
