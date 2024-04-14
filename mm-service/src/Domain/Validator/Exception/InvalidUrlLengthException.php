<?php

declare(strict_types=1);

namespace App\Domain\Validator\Exception;

class InvalidUrlLengthException extends InvalidUrlException
{
    public function __construct(string $value, int $maxLength)
    {
        $message = sprintf(
            'URL length should be less %d. Got: %d',
            $maxLength,
            mb_strlen($value),
        );

        parent::__construct($message);
    }
}
