<?php

declare(strict_types=1);

namespace IlyaPlotnikov\MailService\Services;

class MailService
{
    public function validate(array $emails): bool
    {
        foreach ($emails as $email) {
            if (!$this->validateEmail($email)) {
                return false;
            }
        }

        return true;
    }

    private function validateEmail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $explodedEmail = explode('@', $email);
            $domain = array_pop($explodedEmail);

            return getmxrr($domain, $hosts);
        }

        return false;
    }
}
