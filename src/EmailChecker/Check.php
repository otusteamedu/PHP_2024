<?php

namespace VladimirGrinko\EmailChecker;

class Check
{
    public function check(string $emailsStr): bool
    {
        $emailsStr = $this->strToLower($emailsStr);

        $arEmails = explode(',', $emailsStr);

        foreach ($arEmails as $email) {
            $email = trim($email);
            if (!$this->validateRegex($email)) {
                return false;
            }
            $domain = explode('@', $email)[1];
            if (!$this->validateMX($domain)) {
                return false;
            }
        }

        return true;
    }

    private function strToLower(string $string): string
    {
        return mb_strtolower($string);
    }

    private function validateRegex(string $email): bool
    {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        return preg_match($regex, $email);
    }

    private function validateMX(string $domain): bool
    {
        $mxHosts = [];
        return getmxrr($domain, $mxHosts);
    }
}
