<?php

class EmailVerifier
{
    public function verifyEmailList(array $emails): array
    {
        $results = [];

        foreach ($emails as $email) {
            $results[$email] = $this->verifyEmail($email);
        }

        return $results;
    }

    public function verifyEmail(string $email): bool
    {
        if (!$this->isValidEmailFormat($email)) {
            return false;
        }

        if (!$this->hasMxRecord($email)) {
            return false;
        }

        return true;
    }

    private function isValidEmailFormat(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function hasMxRecord(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, "MX");
    }
}
