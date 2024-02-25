<?php

declare(strict_types=1);

namespace Pozys\EmailValidator\Services;

class InputValidator
{
    public function onlyString(array $data): bool
    {
        foreach ($data as $item) {
            if (!is_string($item)) {
                return false;
            }
        }
        return true;
    }
}
