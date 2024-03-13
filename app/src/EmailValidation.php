<?php
declare(strict_types=1);

final class EmailValidation
{

    public function validate(array $emails): array
    {
        $validEmails = [];

        foreach ($emails as $item) {
            $email = $this->regCheck($item);
            if ($email) {
                $this->dnsCheck($item)? $validEmails[] = $item: false;
            }

        }
        return $validEmails;
    }

    private function regCheck($email): string|false
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function dnsCheck(string $email): bool
    {
        $email = explode('@',$email);

        return getmxrr($email[1],$email[1]);
    }
}