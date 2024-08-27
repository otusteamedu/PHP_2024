<?php

namespace FTursunboy\Validation;

class ValidateEmail
{
    private array $emails;

    public function __construct(array $emails) {
        $this->emails = $emails;
    }

    public function validateEmails(): array {
        $results = [];

        foreach ($this->emails as $email) {
            $results[$email] = $this->validateEmail($email);
        }

        return $results;
    }

    private function validateEmail(string $email): bool {
        if (!$this->isValidFormat($email)) {
            return false;
        }

        return $this->hasValidMXRecord($email);
    }

    private function isValidFormat(string $email): bool {

        $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        return preg_match($regex, $email) === 1;
    }

    private function hasValidMXRecord(string $email): bool {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain);
    }
}
