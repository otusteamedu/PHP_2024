<?php

declare(strict_types=1);

namespace AlexanderPogorelov\EmailValidator;

class EmailValidator
{
    public function validateEmails(array $emails): array
    {
        $output = [];

        foreach ($emails as $email) {
            $output[$email] = $this->validateEmail($email);
        }

        return $output;
    }

    public function validateEmail(string $email): bool
    {
        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return $this->validateByHost($email);
    }

    private function validateByHost(string $email): bool
    {
        $hosts = [];
        $start = \mb_strrpos($email, '@') + 1;
        $hostname = \mb_substr($email, $start);

        return getmxrr($hostname, $hosts);
    }
}
