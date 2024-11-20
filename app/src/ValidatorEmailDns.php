<?php

namespace Dsergei\Hw6;

class ValidatorEmailDns implements IValidator
{
    private $valid;

    private const REGEX = '/@\S+\.\S+$/';

    public function validate(string $email): bool
    {
        $valid = preg_match(self::REGEX, $email, $match);

        if (!$valid) {
            return false;
        } else {
            $dns = str_replace('@', '', $match[0]);
            $valid = checkdnsrr($dns);
            if (!$valid) {
                return false;
            } else {
                return true;
            }
        }
    }
}
