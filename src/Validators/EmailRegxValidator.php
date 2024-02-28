<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Validators;

class EmailRegxValidator
{
    public function __invoke(string $email): bool
    {
        if (preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
