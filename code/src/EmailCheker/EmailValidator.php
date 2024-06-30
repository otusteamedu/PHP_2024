<?php

declare(strict_types=1);

namespace Otus\App\EmailCheker;

class EmailValidator
{
    public function validate(string $email)
    {
        return $this->formatCheck($email) && $this->mxCheck($email);
    }

    private function formatCheck(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function mxCheck(string $email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        $res = getmxrr($domain, $mx_records, $mx_weight);
        return $res != false && count($mx_records) != 0 && !(count($mx_records) == 1 && ($mx_records[0] == null  || $mx_records[0] == "0.0.0.0"));
    }
}
