<?php

namespace Dsergei\Hw6;

use Dsergei\Hw6\IValidator;

class ValidatorEmailName extends AbstractValidator implements IValidator
{
    private const REGEX = '/^\S+@\S+\.\S+$/';

    public function validate(string $email): void
    {
        $valid = preg_match(self::REGEX, $email);

        if (!$valid) {
            $this->log()->send("Email $email is not valid");
        } else {
            $this->log()->send("Email $email is valid");
        }
    }
}
