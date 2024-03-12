<?php

declare(strict_types=1);

namespace IlyaPlotnikov\MailService\Services;

class MailService
{
    public function validate(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $explodedEmail = explode('@', $email);
            $domain = array_pop($explodedEmail);

            return getmxrr($domain, $hosts);
        }

        return false;
    }
}
