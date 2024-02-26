<?php

namespace Dsergei\Hw6;

class ValidatorEmailDns extends AbstractValidator implements IValidator
{
    private $valid;

    private const REGEX = '/@\S+\.\S+$/';

    public function validate(string $email): void
    {
        $valid = preg_match(self::REGEX, $email, $match);

        if (!$valid) {
            $this->log()->send("Dns {$match[0]} is not valid");
        } else {
            $dns = str_replace('@', '', $match[0]);
            $valid = checkdnsrr($dns);
            if (!$valid) {
                $this->log()->send("Dns $dns is not valid");
            } else {
                $this->log()->send("Dns $dns is valid");
            }
        }
    }
}
