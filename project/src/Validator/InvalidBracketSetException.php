<?php

declare(strict_types=1);

namespace SFadeev\HW4\Validator;

use RuntimeException;
use Throwable;

class InvalidBracketSetException extends RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
