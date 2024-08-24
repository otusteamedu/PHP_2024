<?php

namespace Src;

class ValidateEmail
{
    public static function validate(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && getmxrr(explode('@', $email)[1], $hosts);
    }
}