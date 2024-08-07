<?php

declare(strict_types=1);

namespace Udavikhin\OtusHw6;

class EmailValidator
{
    public static function validate(string $email): bool
    {
        $hostname = substr($email, strpos($email, "@") + 1);
        // phpcs:ignore
        $emailRegex = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";
        $mxHosts = [];

        if (
            !preg_match($emailRegex, $email) ||
            !getmxrr($hostname, $mxHosts)
        ) {
            return false;
        }

        return true;
    }
}
