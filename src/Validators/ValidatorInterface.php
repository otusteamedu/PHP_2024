<?php

declare(strict_types=1);

namespace EmailValidation\Validators;

interface ValidatorInterface
{
    public function isValid(string $email): bool;
}
