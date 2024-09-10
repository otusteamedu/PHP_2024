<?php

declare(strict_types=1);

namespace ERybkin\EmailValidator\Validation;

final readonly class EmailValidation implements ValidationInterface
{
    public function validate(string $input): bool
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
    }
}
