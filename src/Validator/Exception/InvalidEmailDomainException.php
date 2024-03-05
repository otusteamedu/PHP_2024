<?php

declare(strict_types=1);

namespace SFadeev\Hw6\Validator\Exception;

class InvalidEmailDomainException extends BaseValidationException
{
    public function __construct(string $value, string $message)
    {
        $message = sprintf('Invalid domain for email: "%s". %s.', $value, $message);

        parent::__construct($message);
    }
}
