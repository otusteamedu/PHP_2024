<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Validators;

use Exception;

class EmailDnsMxValidator
{
    private const RECORD_MX = 'MX';

    public function __invoke(string $email): bool
    {
        $splitEmail = explode('@', $email);

        if (count($splitEmail) !== 2) {
            return false;
        }

        return checkdnsrr($splitEmail[1], self::RECORD_MX);
    }
}
