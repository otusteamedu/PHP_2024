<?php

declare(strict_types=1);

namespace App\Domain\Validator\Exception;

use App\Domain\Exception\InvalidArgumentException;

class InvalidTitleLengthException extends InvalidArgumentException
{
    public function __construct(string $value, int $minLength, int $maxLength)
    {
        $message = sprintf(
            'Title length should be between %d and %d. Got: %d',
            $minLength,
            $maxLength,
            mb_strlen($value),
        );

        parent::__construct($message);
    }
}
