<?php

namespace Den\Hw6;

class EmailService
{
    public function checkEmail(string $email): bool
    {
        $result = filter_var($email, FILTER_VALIDATE_EMAIL);

        if ($result) {
            $domain = explode('@', $email)[1];
            $result = checkdnsrr($domain . '.');
        }

        return $result;
    }
}
