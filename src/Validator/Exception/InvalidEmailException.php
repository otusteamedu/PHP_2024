<?php

declare(strict_types=1);

namespace SFadeev\Hw6\Validator\Exception;

class InvalidEmailException extends BaseValidationException
{
    public function __construct(string $value)
    {
        $message = sprintf('Invalid email: "%s".', $value);

        parent::__construct($message);
    }
}
