<?php

declare(strict_types=1);

namespace Otus\App\EmailChecker;

class EmailValidator
{
    public function validate(string $email): bool
    {
        return $this->formatCheck($email) && $this->mxCheck($email);
    }

    private function formatCheck(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function mxCheck(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        $result = getmxrr($domain, $mx_records);

        return $result &&
            count($mx_records) !== 0 &&
            !(
                count($mx_records) === 1 &&
                ($mx_records[0] === null  || $mx_records[0] == "0.0.0.0")
            );
    }
}
