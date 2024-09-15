<?php

namespace FTursunboy\Validation;

use FTursunboy\Validation\ValidateEmail;

class Validator
{
    public static function validateEmails(array $emails): bool
    {
        $validator = new ValidateEmail($emails);
        $results = $validator->validateEmails();

        foreach ($results as $isValid) {
            if (!$isValid) {
                return false;
            }
        }

        return true;
    }
}
