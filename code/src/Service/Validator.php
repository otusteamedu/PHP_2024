<?php

declare(strict_types=1);

namespace DudkinIv\TestPackage\Service;

class Validator
{
    public function validateEmails(array $emails): bool
    {
        foreach ($emails as $email) {
            if (!$this->validateEmail($email)) {
                return false;
            }
        }

        return true;
    }

    protected function validateEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $email_domain = preg_replace('/^.+?@/', '', $email).'.';
        if (!checkdnsrr($email_domain)) {
            return false;
        }
        return true;
    }
}
