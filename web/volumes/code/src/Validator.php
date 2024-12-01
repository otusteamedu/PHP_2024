<?php

declare(strict_types=1);

namespace RShevtsov\Hw5;

class Validator
{
    protected function regExTest(string $email): bool
    {
        if (preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/i", $email)) {
            return true;
        }

        return false;
    }

    protected function mxTest(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        if (checkdnsrr($domain, "MX")) {
            return true;
        }

        return false;
    }

    public function check(string $email): bool
    {
        return $this->regExTest($email) && $this->mxTest($email);
    }
}
