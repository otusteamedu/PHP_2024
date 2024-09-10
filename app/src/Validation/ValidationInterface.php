<?php

declare(strict_types=1);

namespace ERybkin\EmailValidator\Validation;

interface ValidationInterface
{
    public function validate(string $input): bool;
}
