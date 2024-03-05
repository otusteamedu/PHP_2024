<?php

declare(strict_types=1);

namespace SFadeev\Hw6\Validator\Exception;

class InvalidTypeException extends BaseValidationException
{
    public function __construct(string $given, array $allowed)
    {
        $message = sprintf('Invalid type: %s. Allowed: %s', $given, implode(', ', $allowed));

        parent::__construct($message);
    }
}
