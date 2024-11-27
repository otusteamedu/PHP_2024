<?php

namespace App;

class MailValidationService
{
    const MAILS_PARAM_NAME = 'emails';

    public function validate(array|string $values): bool
    {
        if (is_array($values)) {
            return $this->validateEmailArray($values);
        }

        if (is_string($values)) {
            if (str_contains($values, ',')) {
                $valuesArr = array_map('trim', explode(',', $values));
                return $this->validateEmailArray($valuesArr);
            }

            return $this->validateEmail($values);
        }

        return true;
    }

    private function validateEmailArray(array $values): bool
    {
        foreach ($values as $value) {
            if (!$this->validateEmail($value)) {
                return false;
            }
        }

        return true;
    }

    private function validateEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}