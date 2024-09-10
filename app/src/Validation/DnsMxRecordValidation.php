<?php

declare(strict_types=1);

namespace ERybkin\EmailValidator\Validation;

final readonly class DnsMxRecordValidation implements ValidationInterface
{
    public function validate(string $input): bool
    {
        $domain = explode('@', $input)[1] ?? null;

        return $domain && checkdnsrr($domain);
    }
}
